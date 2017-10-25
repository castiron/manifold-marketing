<?php namespace Castiron\Contentment\FormWidgets;

use Backend\Classes\FormWidgetBase;

class SimplePage extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'simple-page-contents';

    /** @var ContentManager */
    protected $manager;

    /** @var array */
    protected $elementWidgets = [];

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        //$this->prepareVars();
        return $this->makePartial('start');
    }
}
