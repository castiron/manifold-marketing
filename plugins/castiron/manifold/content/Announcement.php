<?php

namespace Castiron\Manifold\Content;

use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Traits\Twiggable;
use Castiron\Lib\Traits\Visible;
use Castiron\News\Models\Article;

/**
 * Announcement Element
 */
class Announcement extends Element
{

    use Twiggable;

    public static function newAnnouncement()
    {
        return Article::visible()->orderBy('date', 'desc')->first();
    }
}
