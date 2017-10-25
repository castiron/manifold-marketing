<?php

namespace Castiron\Contentment\Content\Elements;

use Castiron\Contentment\Content\Element;

class Text extends Element
{
    public function render()
    {
        return $this->body;
    }

    public function renderPreview()
    {
        if (trim($this->body)) {
            return $this->body;
        }
        return "No text";
    }
}
