<?php namespace Castiron\Manifold\Components;

use Cms\Classes\ComponentBase;
use Castiron\Contentment\Models\Page;

/**
 * Class Navigation
 * @package Castiron\Manifold\Components
 */
class Navigation extends ComponentBase
{
    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'navigation Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function pages() {
        return Page::where('site_root', 0)->visible()->get();
    }

    /**
     * @return array
     */
    public function navItems() {
        $navItems = [];

        $pages = static::pages();
        if (!$pages) {
            return [];
        }

        $activeUrl = $this->activeUrl();
        foreach ($pages as $child) {
            if (strpos($activeUrl, $child->getUrl()) === 0) {
                $child->active = true;
            }
            $navItems[] = $child;
        }
        return $navItems;
    }

    /**
     * @return mixed
     */
    public function activeUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
