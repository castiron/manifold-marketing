<?php namespace Castiron\StaticMicrosite\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Castiron\StaticMicrosite\Configuration;
use Castiron\StaticMicrosite\Repository;
use October\Rain\Exception\AjaxException;

/**
 * RepoPullButton Form Widget
 */
class RepoPullButton extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'castiron_staticmicrosite_repo_pull_button';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('repopullbutton');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
      $this->vars['model'] = $this->model;
      $this->vars['values'] = $this->getLoadValue();
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/repopullbutton.css', 'Castiron.StaticMicrosite');
        $this->addJs('js/repopullbutton.js', 'Castiron.StaticMicrosite');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value) {
      return $value;
    }

    protected function getConfiguration() {
      $params = post();
      $name = $params['name'];
      $allSettings = $params['RouteSettings']['settings'];
      preg_match_all("/\[(.*?)\]/", $name, $matches);
      $key = $matches[1][1];
      $settings = $allSettings[$key];
      $config = Configuration::routeToConfig($settings);
      return $config;
    }

    public function onPull() {
        $config = $this->getConfiguration();
        if (!$config) throw new AjaxException(['error' => 'Unable to extract configuration from request']);
        $repository = new Repository($config);
        $status = $repository->pull();
        if ($status !== 0) throw new AjaxException(['error' => 'Error fetching branch/commit']);
        return [];
    }

    protected function getInputName($attribute) {
        return $this->formField->getName()."[".$attribute."]";
    }

    protected function getInputId($attribute) {
        return $this->formField->getId()."-".$attribute;
    }

    protected function getInputValue($attribute) {
        if (!is_array($this->vars['values'])) return null;
            if (array_key_exists($attribute, $this->vars['values'])) {
                return $this->vars['values'][$attribute];
            } else {
                return null;
            }
      }
}
