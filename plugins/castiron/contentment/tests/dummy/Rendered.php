<?php

namespace Castiron\Contentment\Tests\Dummy;

use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Traits\Twiggable;

class Rendered extends Element
{
    use Twiggable;

    public static function sampleData()
    {
        return ['someValue' => '###banana###'];
    }
}
