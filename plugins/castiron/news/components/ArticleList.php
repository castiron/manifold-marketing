<?php namespace Castiron\News\Components;

use Castiron\Lib\Traits\Visible;
use Cms\Classes\ComponentBase;
use Castiron\News\Models\Article;

class ArticleList extends ComponentBase
{
    use Visible;

    public function componentDetails()
    {
        return [
            'name'        => 'ArticleList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public static function orderedArticles() {
        return Article::visible()->orderBy('date', 'desc')->get();
    }
}
