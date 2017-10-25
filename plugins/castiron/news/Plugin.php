<?php namespace Castiron\News;

use Backend;
use System\Classes\PluginBase;

use Castiron\News\Components\ArticleList;
use Castiron\News\Components\ArticleDetail;

/**
 * News Plugin Information File
 */
class Plugin extends PluginBase
{
    const GENERAL_ICON = 'icon-newspaper-o';

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'News',
            'description' => 'News plugin for October CMS projects',
            'author'      => 'Castiron',
            'icon'        => static::GENERAL_ICON,
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            ArticleList::class      => 'articlelist',
            ArticleDetail::class    => 'articledetail',
        ];
    }


    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'news' => [
                'label'       => 'News',
                'url'         => Backend::url('castiron/news/articles'),
                'icon'        => static::GENERAL_ICON,
                'permissions' => ['castiron.news.*'],
                'order'       => 600,
                'sideMenu'    => [
                    'articles' => [
                        'label' => 'Articles',
                        'icon'  => 'icon-pencil-square',
                        'url'   => Backend::url('castiron/news/articles')
                    ],
                ]
            ],
        ];
    }
}
