<?php namespace Castiron\Search;

use Castiron\Search\Components\SearchResults;
use Castiron\Search\Console\PruneIndex;
use System\Classes\PluginBase;

/**
 * Search Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Search',
            'description' => 'Search frontend for queequeg/elasticsearch',
            'author'      => 'Castiron',
            'icon'        => 'icon-search'
        ];
    }

    public function registerPermissions() {
        return [
            'castiron.queequeg.*' => [
                'tab' => 'Castiron',
                'label' => 'Access Search Settings'
            ],
        ];
    }

    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            SearchResults::class => 'searchresults',
        ];
    }

    public function register() {
        parent::register();
        $this->registerConsoleCommand('search.pruneindex', PruneIndex::class);
    }
}
