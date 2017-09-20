<?php namespace Castiron\Manifold\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Features Back-end Controller
 */
class Features extends Controller
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

        BackendMenu::setContext('Castiron.Manifold', 'manifold', 'features');
    }
}
