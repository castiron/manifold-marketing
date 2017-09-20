<?php namespace Castiron\Manifold;

use Backend;
use System\Classes\PluginBase;
use Castiron\Manifold\Components\UserTypes;

/**
 * manifold Plugin Information File
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
            'name'        => 'manifold',
            'description' => 'Functionality for the Manifold Marketing Site',
            'author'      => 'castiron',
            'icon'        => 'icon-leaf'
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
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
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
            UserTypes::class => 'usertypes',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'castiron.manifold.some_permission' => [
                'tab' => 'manifold',
                'label' => 'Some permission'
            ],
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
            'manifold' => [
                'label'       => 'Manifold',
                'url'         => Backend::url('castiron/manifold/features'),
                'icon'        => 'icon-book',
                'permissions' => ['castiron.manifold.*'],
                'order'       => 500,
                'sideMenu'    => [
                  'features' => [
                       'label' => 'Features',
                       'icon'  => 'icon-check-circle-o',
                       'url'   => Backend::url('castiron/manifold/features')
                   ],
                   'feature_categories' => [
                        'label' => 'Feature Categories',
                        'icon'  => 'icon-list',
                        'url'   => Backend::url('castiron/manifold/featurecategories')
                    ],
                    'user_types' => [
                         'label' => 'User Types',
                         'icon'  => 'icon-users',
                         'url'   => Backend::url('castiron/manifold/usertypes')
                     ],
                ]
            ],
        ];
    }
}
