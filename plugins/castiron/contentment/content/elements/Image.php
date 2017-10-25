<?php

namespace Castiron\Contentment\Content\Elements;

use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Traits\Twiggable;
use Cms\Classes\MediaLibrary;

class Image extends Element
{

    use Twiggable;

    public function viewVariables()
    {
        $imagePath = $this->image;
        if (!$imagePath) {
            return [];
        }
        return [
            'imagePath' => MediaLibrary::url($this->image)
        ];
    }

}
