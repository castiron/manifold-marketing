<?php

namespace Castiron\Contentment\Content\Elements;

use Castiron\Contentment\Content\Element;

class InvalidElement extends Element
{

    public function renderPreview()
    {
        return $this->error;
    }
}
