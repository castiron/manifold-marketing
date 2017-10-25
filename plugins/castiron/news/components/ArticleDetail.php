<?php namespace Castiron\News\Components;

use Castiron\News\Models\Article;
use Cms\Classes\ComponentBase;
use Castiron\Lib\Traits\Visible;

class ArticleDetail extends ComponentBase
{
    use Visible;

    protected $model;
    protected $slugParameter = 'slug';
    protected $slugColumn = 'slug';
    protected $modelClass = Article::class;
    protected $titleColumn = 'title';

    public function componentDetails()
    {
        return [
            'name'        => 'ArticleDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init()
    {
        parent::init();
        $slug = $this->param($this->slugParameter);
        $this->model = $this->loadModel($slug);
        if (!$this->article()) {
            \Response::make($this->controller->run('404'), 404);
        }
    }

    protected function loadModel($slug)
    {
        if ($this->modelClass) {
            $class = $this->modelClass;
            return $class::where([$this->slugColumn => $slug])->first();
        }
    }

    public function onRun()
    {
        if ($this->model) {
            $this->page->page->title = $this->pageTitle();
            $this->page->page->title_tag_value = $this->pageTitleTag();
        }
    }

    /**
     * @return \October\Rain\Database\Model
     */
    public function article() {
        if($this->model->getIsVisibleAttribute()) {
            return $this->model;
        }
    }

    /**
     * @return mixed|string
     */
    protected function pageTitle()
    {
        return $this->model->{$this->titleColumn};
    }

    /**
     * @return mixed|string
     */
    protected function pageTitleTag() {
        return $this->model->title;
    }
}
