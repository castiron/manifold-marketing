<?php namespace Castiron\Forms;

use Backend;
use System\Classes\PluginBase;
use Castiron\Forms\Components\ContactForm;

/**
 * Forms Plugin Information File
 */
class Plugin extends PluginBase
{
    const PLUGIN_ICON = 'icon-check-square-o';

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Forms',
            'description' => 'No description provided yet...',
            'author'      => 'Castiron',
            'icon'        => static::PLUGIN_ICON,
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
            ContactForm::class => 'contactform',
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
            'forms' => [
                'label'       => 'Forms',
                'url'         => Backend::url('castiron/forms/contacts'),
                'icon'        => static::PLUGIN_ICON,
                'order'       => 700,
                'sideMenu'  => [
                    'contacts' => [
                        'label' => 'Contacts',
                        'icon'  => 'icon-users',
                        'url'   => Backend::url('castiron/forms/contacts'),
                    ],
                ]
            ],
        ];
    }

    public function registerMailTemplates() {
        return [
            'castiron.forms::mail.contact-message' => 'Notification template for Contact form submission.',
        ];
    }
}
