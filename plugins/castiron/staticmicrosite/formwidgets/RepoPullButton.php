<?php namespace Castiron\StaticMicrosite\FormWidgets;

use Backend\Classes\FormWidgetBase;
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
    public function getSaveValue($value)
    {
        return $value;
    }

    public function onPull() {
        $params = post();
        $stringPath = $params['name'];
        preg_match_all("/\[(.*?)\]/", $stringPath, $rgMatches);
        $rgResult = $params['RouteSettings'];

        foreach($rgMatches[1] as $sPath) # https://stackoverflow.com/questions/19028963/access-array-using-dynamic-path#answer-19029098
        {
          $rgResult=$rgResult[$sPath];
        }
        $rgResult = $rgResult['repo'];

        $path = $rgResult['content_root_path'] ?: null;

        if (!$path) throw new AjaxException(['error' => 'No path to repo specified']);
        $target = $rgResult['branch_or_commit'] ?: 'origin/master';

        $this->pullRepo($path, $target);

        return [];
    }

    protected function pullRepo($path, $target) {
      if (!$path || !$target) return null;
      $command = "cd ".$path."; git fetch --all; git reset --hard ".$target;
      $output = [];
      $status = null;
      exec($command, $output, $status);

      if ($status !== 0) throw new AjaxException(['error' => 'Error fetching branch/commit']);
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
