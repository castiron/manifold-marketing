<?php

namespace Castiron\Contentment\Tests\Dummy;

use Castiron\Contentment\Content\Element;
use October\Rain\Database\Traits\Validation;

class Complex extends Element
{
    public $events = [];

    use Validation;

    public $rules = [
        'someValue' => 'required|between:10,40',
    ];

    public function render()
    {
        return $this->someValue;
    }

    public static function unboot()
    {
        static::$booted = [];
    }

    public static function boot()
    {
        parent::boot();
        $events = [
            'creating', 'created', 'updating', 'updated',
            'deleting', 'deleted', 'saving', 'saved',
        ];
        foreach ($events as $event) {
            static::$event(function ($x) use ($event) {
                $x->events[] = $event;
            });
        }
    }

    public static function sampleData()
    {
        return ['someValue' => '<p>Lookie here, this could be part of a larger more complex structure</p>'];
    }

}
