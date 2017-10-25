<?php namespace Castiron\Contentment\Content\Elements;

use Castiron\Contentment\Content\Element;

/**
 * Class Html
 * @package Castiron\Contentment\Content\Elements
 */
class Html extends Element
{
    /**
     * @return mixed|string
     */
    public function render()
    {
        return $this->body;
    }

    /**
     * @return mixed|string
     */
    public function renderPreview()
    {
        if (trim($this->body)) {

            return htmlspecialchars(str_limit($this->body, 150));
        }
        return "No content";
    }
}
