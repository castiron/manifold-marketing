<?php

namespace Castiron\Contentment\Content;

use October\Rain\Database\Model;

abstract class SimplePage extends Model
{
    // laravel settings for these types of models
    protected static $unguarded = true;
    protected $guarded = [];
    public $timestamps = false;
}
