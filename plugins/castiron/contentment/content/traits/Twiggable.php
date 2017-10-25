<?php

namespace Castiron\Contentment\Content\Traits;

use Cms\Classes\CmsException;
use Cms\Classes\Controller;
use System\Traits\ViewMaker;


/**
 * This is
 */
trait Twiggable
{

    use ViewMaker;

    protected $template = 'default.htm';
    protected $previewTemplate = 'preview.htm';


    /**
     * Quite simply rendering the twig template
     * @return string
     */
    public function render()
    {
        return $this->renderTemplate($this->template);
    }

    /**
     * Quite simply rendering the twig template
     * @return string
     */
    public function renderPreview()
    {
        return $this->renderTemplate($this->previewTemplate);
    }

    /**
     * Our twig setup requires the runtime controller,
     * so pre-rendering is not possible.
     *
     * @return false
     */
    public function renderStatic()
    {
        return false;
    }

    /**
     * Additional variables to add to the view
     *
     * @return array
     */
    public function viewVariables()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getViewDirectories()
    {
        $base = $this->guessViewPathFrom($this);

        $out = [$base];

        // If a shared folder exists, add it
        $sharedFolder = $base . '/../_shared/';
        if (file_exists($sharedFolder) && is_dir($sharedFolder)) {
            array_push($out, $sharedFolder);
        }

        return $out;
    }

    /**
     * @return string
     */
    protected function renderTemplate($template)
    {
        // Make our own twig loader for our path
        $loader = new \Twig_Loader_Filesystem($this->getViewDirectories());

        // Use the CMS Controller's Twig environment
        $c = Controller::getController() ?: new Controller();
        $twig = $c->getTwig();

        // Replace the CMS loader with our own
        $cmsLoader = $c->getLoader();
        $twig->setLoader($loader);

        // Render
        $result = $twig->render($template, array_merge($this->attributes, ['model' => $this], $this->viewVariables()));

        // Don't forget to put this back!
        $twig->setLoader($cmsLoader);

        return $result;


    }
}
