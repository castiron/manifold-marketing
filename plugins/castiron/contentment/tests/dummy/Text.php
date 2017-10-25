<?php

namespace Castiron\Contentment\Tests\Dummy;

use \Castiron\Contentment\Content\Elements\Text as TextElement;

class Text extends TextElement
{
    public $events = [];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $events = [
            'model.saveInternal',
            'model.beforeSave',
            'model.afterSave',
        ];
        foreach ($events as $event) {
            $this->bindEvent($event, function () use ($event) {
                $this->events[] = $event;
            });
        }
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
        return ['body' => '<p>Some value here</p>'];
    }

}
