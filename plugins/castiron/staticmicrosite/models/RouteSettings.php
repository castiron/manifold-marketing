<?php namespace Castiron\StaticMicrosite\Models;

use Model;

/**
 * RouteSettings Model
 */
class RouteSettings extends Model
{

  public $implement = ['System.Behaviors.SettingsModel'];

  public $settingsCode = 'castiron_staticmicrosite_routesettings';

  public $settingsFields = 'fields.yaml';

}
