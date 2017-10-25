<?php

namespace Castiron\Contentment\Components;

class Page extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Page Content',
            'description' => 'Renders Page Content.'
        ];
    }

    // This array becomes available on the page as {{ component.posts }}
    public function posts()
    {
        return ['First Post', 'Second Post', 'Third Third'];
    }

    public function defineProperties()
    {
        return [
            'pageId' => [
                'title'             => 'Page ID',
                'description'       => 'Page ID to Render',
                'default'           => null,
                'type'              => 'integer'
            ]
        ];
    }
}

