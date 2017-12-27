<?php namespace Castiron\StaticMicrosite;

use Backend;
use Castiron\Manifold\Console\FetchRss;
use System\Classes\PluginBase;
use Castiron\StaticMicrosite\Models\RouteSettings;

/**
 * StaticMicrosite Plugin Information File
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
            'name'        => 'StaticMicrosite',
            'description' => 'No description provided yet...',
            'author'      => 'Castiron',
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
      $this->registerConsoleCommand('rss.fetch', FetchRss::class);
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
        return []; // Remove this line to activate

        return [
            'Castiron\StaticMicrosite\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
            'castiron.staticmicrosite.*' => [
                'tab' => 'Static Microsites',
                'label' => 'Configure static microsites'
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
        return []; // Remove this line to activate

        return [
            'staticmicrosite' => [
                'label'       => 'StaticMicrosite',
                'url'         => Backend::url('castiron/staticmicrosite/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['castiron.staticmicrosite.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerFormWidgets()
    {
      return [
        'Castiron\StaticMicrosite\FormWidgets\RepoPullButton' => 'repopullbutton',
      ];
    }

  public function registerSettings()
    {
        return [
            'route_settings' => [
                'label' => 'Configuration',
                'description' => '',
                'category' => 'Static Microsites',
                'icon' => 'icon-exchange',
                'class' => RouteSettings::class,
                'order' => 100,
                'permissions' => ['castiron.staticmicrosite.*']
            ]
        ];
    }
}
