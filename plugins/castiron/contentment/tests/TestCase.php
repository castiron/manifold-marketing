<?php

namespace Castiron\Contentment\Tests;

use Castiron\Contentment\Models\Page;
use Castiron\Contentment\Models\TextContent;
use Castiron\Tests\BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * @param bool $save
     * @param array $attrs
     * @return Post
     */
    protected static function page($save = true, $attrs = [])
    {
        list($save, $attrs) = self::saveAndOrAttrs(func_get_args());
        static $c = 0;
        $names = ['uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete'];
        if ($c == count($names)) $c = 0;
        $title = $attrs['title'] ?: $names[$c++];
        $defaults = [
            'title' => $title,
            'slug' => str_slug($title),
            'template' => 'some-template',
        ];
        $model = new Page(array_merge($defaults, $attrs));
        if ($save) $model->save();
        return $model;
    }

    /**
     * @param bool $save
     * @param array $attrs
     * @return Post
     */
    protected static function textContent($save = true, $attrs = [])
    {
        list($save, $attrs) = self::saveAndOrAttrs(func_get_args());
        static $c = 0;
        $names = ['alpha', 'beta', 'gamma', 'delta', 'epsilon', 'zeta', 'eta'];
        if ($c == count($names)) $c = 0;
        $defaults = [
            'body' => $names[$c++],
        ];
        $model = new TextContent(array_merge($defaults, $attrs));
        if ($save) $model->save();
        return $model;
    }

    private static function saveAndOrAttrs($args)
    {
        switch (count($args)) {
            case 2:
                if (is_array($args[0])) {
                    $saved = $args[1];
                    $attrs = $args[0];
                } else {
                    $saved = $args[0];
                    $attrs = $args[1];
                }
                break;
            case 1:
                if (is_array($args[0])) {
                    $attrs = $args[0];
                    $saved = true;
                } else {
                    $saved = $args[0];
                    $attrs = [];
                }
                break;
            default:
                $saved = true;
                $attrs = [];
        }
        return [$saved, $attrs];
    }


}
