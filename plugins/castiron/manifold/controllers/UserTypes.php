<?php namespace Castiron\Manifold\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * User Types Back-end Controller
 */
class UserTypes extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Castiron.Manifold', 'manifold', 'usertypes');
    }
}
