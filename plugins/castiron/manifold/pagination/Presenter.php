<?php namespace Castiron\Manifold\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use URL;
use Request;

/**
 * Class PaginationPresenter
 * @package Castiron\Manifold\Presenters
 */
class Presenter
{
    /**
     * PaginationPresenter constructor.
     * @param LengthAwarePaginator $paginator
     * @param UrlWindow|null $window
     */
    public function __construct(LengthAwarePaginator $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator, 2) : $window->get(2);
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages())
        {
            return sprintf(
                '%s %s %s',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';
//        $url = static::overlayQueryStringOnCurrent('page=' . intval($page));
        return '<li><a data-list-page="' . $page . '" href="' . static::getBaseUri() . htmlentities($url) . '"' . $rel . '>' . $page . '</a></li>';
    }

//    /**
//     * @param string $addQueryString
//     * @return mixed
//     */
//    protected static function overlayQueryStringOnCurrent($addQueryString = '') {
//        $out = '';
//        if (!$addQueryString) {
//            return $out;
//        }
//
//        /**
//         * Check for input params
//         */
//        if ($input = input()) {
//            parse_str($addQueryString, $add);
//            $merged = array_merge($input, $add);
//            $out .= '?' . http_build_query($merged);
//
//        }
//
//        return $out;
//    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li>
    <a class="disabled">
        ' . $text . '
    </a>
</li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="active"><span><a class="active" data-list-page="' . $text . '" href="'
            . static::getBaseUri()
            . $this->paginator->url($this->paginator->currentPage()) . '">' . $text . '</a></span></li>';
    }

    /**
     * @return mixed
     */
    protected static function getBaseUri() {
        $currentUrl = URL::current();
        $parts = parse_url($currentUrl);
        return $parts['path'];
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return '<li class="ellipses">...</li>';
    }

    /**
     * Get the current page from the paginator.
     *
     * @return int
     */
    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }

    /**
     * Get the previous page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getPreviousButton($text = '&laquo;')
    {
        // If the current page is less than or equal to one, it means we can't go any
        // further back in the pages, so we will render a disabled previous button
        // when that is the case. Otherwise, we will give it an active "status".
        if ($this->paginator->currentPage() <= 1)
        {
            return '<li><a class="pager-left disabled">
    <span class="screen-reader-text">Click for previous page</span>
</a></li>';
        }

        $page = $this->paginator->currentPage() - 1;
        $url = static::getBaseUri() . $this->paginator->url(
                $page
            );

        return '<li><a href="' . $url . '" data-list-page=" ' . $page . '" class="pager-left">
    <span class="screen-reader-text">Click for previous page</span>
</a></li>';
    }

    /**
     * Get the next page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getNextButton($text = '&laquo;')
    {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if ( ! $this->paginator->hasMorePages())
        {
            return '<li><a class="pager-right disabled">
    <span class="screen-reader-text">Click for next page</span>
</a></li>';
        }
        $page = $this->paginator->currentPage() + 1;
        $url = static::getBaseUri() . $this->paginator->url($page);

        return '<li><a href="' . $url . '" data-list-page=" ' . $page . '" class="pager-right">
    <span class="screen-reader-text">Click for next page</span>
</a></li>';
    }
}
