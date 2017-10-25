<?php namespace Castiron\Search\Console;

use Castiron\Peaches\Support\Arr;
use Castiron\Search\Contracts\SearchQuery;
use Castiron\Search\Service\Connection;
use Queequeg\Service\Connection as QueequegConnection;
use Illuminate\Console\Command;
use Queequeg\Contracts\Searchable;
use Queequeg\Service\Catalog;

/**
 * Class PruneIndex
 * @package Castiron\Search\Console
 */
class PruneIndex extends Command
{
    const BATCH_SIZE = 200;

    /**
     * The searchables (so we don't have to load them more than once)
     * @var array
     */
    protected $searchables;

    /**
     * @var string The console command name.
     */
    protected $name = 'search:pruneindex';

    /**
     * @var string The console command description.
     */
    protected $description = 'Prune the search index of defunct and non-searchable items';

    /**
     * @return SearchQuery
     */
    protected function getQuery() {
        return app(SearchQuery::class);
    }

    /**
     * @param $msg
     */
    protected function bigLine($msg) {
        $this->line("\n$msg\n");
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function fire() {
        $prunables = $this->getPrunables();
        if (!$prunables) {
            $this->line('No items found that can be pruned');
        }
        $i = 0;
        foreach ($prunables as $hit) {
            $this->comment('Pruning ' . static::hitIdentifier($hit));
            $this->removeItemFromIndex($hit);
            if ($i > 0 && $i % static::BATCH_SIZE === 0) {
                $this->bigLine('Sleeping 10 seconds so we don\'t slam the Queequeg server');
                sleep(10);
            }
            $i++;
        }
    }

    /**
     * @param $hit
     */
    protected function removeItemFromIndex($hit) {
        if (!$hit->_id) {
            return;
        }
        $session = [$hit->_type => [
            [
                'url' => $hit->_source->url,
                'uid' => $hit->_id,
            ],
        ]];
        QueequegConnection::instance()->sendSession('delete', $hit->_index, $session);
    }

    /**
     * @return array
     */
    protected function getPrunables() {
        $query = $this->getQuery();
        $query->setSize(static::BATCH_SIZE);

        $out = [];

        $i = 0;
        while ($res = json_decode(Connection::instance()->search($query))) {
            /** We're done if there are no more hits */
            if (!$res->hits->hits) {
                break;
            }

            $out = array_merge($out, $this->filterToPrunables($res->hits->hits));

            /** Iterate */
            $i += static::BATCH_SIZE;
            $query->setFrom($i);
        }
        return $out;
    }

    /**
     * @param object $hit
     * @return Searchable
     */
    protected function getModelFromHit($hit) {
        $searchables = $this->getSearchables();

        /** @var Searchable $class */
        $class = $searchables[$hit->_type];
        if (!$class) {
            return null;
        }

        if (!$hit->_id) {
            return null;
        }

        return $class::findBySearchIdentifier($hit->_id);
    }

    /**
     * @return array
     */
    protected function getSearchables() {
        if (!$this->searchables) {
            $this->searchables = Catalog::loadSearchablesFromPlugins();
        }
        return $this->searchables;
    }

    /**
     * @param $hit
     * @return string
     */
    public static function hitIdentifier($hit) {
        return implode(':', [
            $hit->_index,
            $hit->_type,
            $hit->_id,
        ]);
    }

    /**
     * @param $hits
     * @return array
     */
    protected function filterToPrunables($hits) {
        return array_filter($hits, function($hit) {
            $this->comment('Checking ' . static::hitIdentifier($hit));
            $model = $this->getModelFromHit($hit);
            if (!$model) {
                return true;
            }
            return !$model->isSearchable();
        });
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments() { return []; }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions() { return []; }

}
