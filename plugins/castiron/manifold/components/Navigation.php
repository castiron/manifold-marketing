<?php namespace Castiron\Manifold\Components;

use Cms\Classes\ComponentBase;
use Castiron\Contentment\Models\Page;

class Navigation extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'navigation Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getRootPage() {
        return Page::findByUrl('/');
    }

    /**
     * @return bool
     */
    public function hasChildren() {
        if (count($this->getRootPage()->getVisibleChildren())) {
            return true;
        } else {
           return false;
        }
    }

    /**
     * @return mixed
     */
    public function children() {
        if ($this->hasChildren()) {
            return $this->getRootPage()->getVisibleChildren();
        } else {
          return false;
        }
    }

    public function navItems() {
      $navItems = [];
      $rootSlug = $this->getRootPage()['slug'];

      if ($this->children()) {
        foreach ($this->children() as $child) {
          $fullUrl = '/' . $rootSlug . '/' . $child['slug'];
          $active = ($fullUrl == $this->activeUrl()) ? 'active' : '';
          $url = strpos($this->activeUrl(), $rootSlug) !== false ? $child['slug'] : $fullUrl;
          array_push($navItems, array('url' => $url, 'text' => $child['title'], 'active' => $active));
        }
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
