<?php namespace Castiron\Manifold\Components;

use Castiron\Manifold\Pagination\Presenter;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class SearchResults
 * @package Castiron\Manifold\Components
 */
class SearchResults extends \Castiron\Search\Components\SearchResults
{
    public function init() {
        $this->funcs[] = 'paginationPresenter';
        parent::init();
    }

    /**
     *
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

        $out = new LengthAwarePaginator($results, $total, $perPage, $currentPage);
        $out->appends(array_filter(input()));

        return $out;
    }

    /**
     * @return Presenter
     */
    public function paginationPresenter() {
        return new Presenter($this->paginationDetails());
    }
}
