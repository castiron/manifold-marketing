<?php namespace Castiron\Manifold\Pagination;

/**
 * Class UrlWindow
 * @package Castiron\Manifold\Pagination
 */
class UrlWindow extends \Illuminate\Pagination\UrlWindow
{
    /**
     * Get the starting URLs of a pagination slider.
     *
     * @return array
     */
    public function getStart()
    {
        return $this->paginator->getUrlRange(1, 1);
    }

    /**
     * Get the ending URLs of a pagination slider.
     *
     * @return array
     */
    public function getFinish()
    {
        return $this->paginator->getUrlRange(
            $this->lastPage(),
            $this->lastPage()
        );
    }
}
