<?php namespace Castiron\Search\Components;

use October\Rain\Support\Facades\Flash;
use Queequeg\Service\Catalog;
use Castiron\Components\ComponentBase;
use Castiron\Search\Service\Connection;
use Castiron\Search\Contracts\SearchQuery;

class SearchResults extends ComponentBase
{

    protected $funcs = [
        'typeOptions',
        'results',
        'paginationDetails',
        'activeType',
        'activeQuery',
        'activePage',
        'boostType',
    ];

    /** @var SearchQuery */
    protected $query;

    /** @var SearchQuery */
    protected $countQuery;

    public function init() {
        parent::init();
        $this->query = app(SearchQuery::class);
        $this->query->setSize($this->property('perPage'));
        $this->countQuery = app(SearchQuery::class);
    }

    public function componentDetails()
    {
        return [
            'name'        => 'Search Results',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'perPage' => [
                'title'             => 'Results per page',
                'description'       => 'Number of search results to show on each paginated page',
                'default'           => 20,
                'type'              => 'integer',
                'validationPattern' => '^[0-9]+$',
                'required'          => true,
            ]
        ];

    }

    protected function resultCountForType($key, $index = null) {
        $this->countQuery->setType($key);
        if ($index) {
            $this->countQuery->setIndex($index);
        }
        if ($keyword = $this->activeQuery()) {
            $this->countQuery->setKeyword($keyword);
        }
        try {
            $response = json_decode(Connection::instance()->search($this->countQuery));
        } catch (\Exception $e) {
            return 0;
        }
        return $response->hits->total;
    }

    /**
     * @param null $index
     * @return array
     */
    public function typeOptions($index = null)
    {
        $options = [];

        if ($settings = Catalog::loadSearchablesByIndexFromPlugins($index)) {
            foreach ($settings as $index => $data) {
                foreach ($data['types'] as $key => $details) {
                    $options[$key] = [
                        'label' => $details['label'],
                        'count' => $this->resultCountForType($key)
                    ];
                }
            }
        }

        return $options;
    }

    public function onSearch()
    {
        // No-op; All this does is refresh the page;
        // Other functions (results()) are called to put data on the page
    }

    public function activePage() {
        return input('page') || 1;
    }

    public function activeQuery() {
        return input('q');
    }

    public function activeType() {
        return input('type');
    }

    public function boostType() {
        return input('boost_type');
    }

    /**
     * @return mixed|string
     */
    public function results($index = null)
    {
        if ($index) {
            $this->query->setIndex($index);
        }

        if ($keyword = $this->activeQuery()) {
            $this->query->setKeyword($keyword);
        }

        if ($type = $this->activeType()) {
            $this->query->setType($type);
        }

        if ($boostType = $this->boostType()) {
            $this->query->setBoostType($boostType);
        }

        if ($page = input('page')) {
            $this->query->setFrom(($page - 1) * $this->property('perPage'));
        }

        try {
            $response = json_decode(Connection::instance()->search($this->query));
        } catch (\Exception $e) {
            Flash::error("We're sorry, site search is currently unavailable. Please check back later.");
            return '';
        }

        if (is_object($response)) {
            return json_decode(json_encode($response->hits), true);
        } else return '';
    }

    /**
     * returns pagination details based on current query settings
     * @return array
     */
    public function paginationDetails()
    {
        $results = $this->results();

        if (is_array($results)) {
            $total = $results['total'];
        } else $total = 0;

        $currentOffset = $this->query->getFrom();
        $perPage = $this->property('perPage');
        $currentPage = ($currentOffset / $perPage) + 1;

        $hasNext = false;
        if ($total > $currentPage * $perPage) {
            $hasNext = true;
        }

        return array(
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'hasNext' => $hasNext,
            'nextPage' => $hasNext ? $currentPage + 1 : null,
            'hasPrevious' => $currentPage > 1,
            'previousPage' => $currentPage > 1 ? $currentPage - 1 : null
        );
    }

}
