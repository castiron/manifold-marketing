<?php namespace Castiron\Contentment\FormWidgets;


use Input;
use Backend;
use Backend\Classes\FormWidgetBase;
use Flash;
use Castiron\Contentment\Content\Manager as ContentManager;
use Castiron\Contentment\Models\Content as ContentModel;

/**
 * Content Form Widget
 */
class Content extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'page-contents';

    /** @var ContentManager */
    protected $manager;

    /** @var array */
    protected $elementWidgets = [];

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->manager = ContentManager::instance();
        $session = Input::get('content_session');
        if ($session) {
            $this->sessionKey = $session;
        }

        foreach ($this->pageContents() as $c) {
            $id = $c->id;
            $this->elementWidgets[$id] = $this->makeFormWidgetForElement($c);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('start');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['contentElements'] = $this->manager->elements();
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/content.css', 'Castiron.Contentment');
        $this->addJs('js/content.js', 'Castiron.Contentment');
    }

    /**
     * @return array
     */
    public function onAddContent()
    {
        $this->manager->makeContent(
            post('identifier'),
            $this->model,
            $this->sessionKey
        );
        $this->prepareVars();
        return $this->runResults([], 'content');
    }

    /**
     * @return array
     */
    public function onHideContent()
    {
        $c = ContentModel::findOrFail(post('content_id'));
        $c->toggleHidden();
        $c->save();
        return $this->runResults([], 'content');
    }

    /**
     * @return array
     */
    public function onRemoveElement()
    {
        $c = ContentModel::findOrFail(post('content_id'));
        $name = $c->element()->typeLabel();
        $c->delete();
        Flash::success("Deleted $name successfully");
        return $this->runResults([], 'content');
    }

    /**
     *
     */
    public function onSortContent()
    {
        $ids = post('content_ids');
        $c = new ContentModel;
        $c->setSortableOrder($ids, array_keys($ids));
    }

    /**
     * Normally, AJAX partials are returned like ['#jquerySelector' => '<p>partial contents</p>'];
     * but, this only works for _controller_ partials not widget partials :( as far as i can tell
     * so we're doing it manually here.
     *
     * @param array $result
     * @param string $partial
     * @param array $params
     * @return array
     * @throws \SystemException
     */
    protected function runResults($result, $partial, $params = array())
    {
        $update = Input::get('update');
        if (empty($update)) return $result;
        return array_merge($result, [$update => $this->makePartial($partial, $params)]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function onEditElement()
    {
        $id = post('content_id');
        if (isset($this->elementWidgets[$id])) {
            return $this->makePartial('element_form', [
                'formWidget' => $this->elementWidgets[$id],
                'content' => ContentModel::findOrFail($id),
            ]);
        }
        throw new \Exception("Could not find content element widget with id '$id'");
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function onSaveElement()
    {
        $id = post('content_id');
        $content = ContentModel::findOrFail($id);
        if (isset($this->elementWidgets[$id])) {
            $widget = $this->elementWidgets[$id];
            $saveData = $widget->getSaveData();

            $element = $content->element();
            $element->commitDeferred($this->sessionKey);

            $content->setData($saveData);
            $content->save();

            $name = $element->typeLabel();
            Flash::success("Saved $name successfully");
            return $this->runResults([], 'content');
        }
        throw new \Exception("Could not find content element widget with id '$id'");
    }

    /**
     * todo
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    /**
     * @return mixed
     */
    public function pageContents()
    {
		return $this->model->contents()->withDeferred($this->sessionKey)->ordered()->get();
    }

    /**
     * @param ContentModel $content
     * @return Backend\Classes\WidgetBase
     */
    protected function makeFormWidgetForElement(ContentModel $content)
    {
        $element = $content->element();
        $configPath = $this->guessConfigPathFrom($element);
        $config = $this->makeConfig($configPath.'/fields.yaml');
        $config->model = $element;
        $config->context = 'update';
        $config->arrayName = class_basename($element);
        $config->alias = $this->alias . '_ElementForm_'.$content->id;
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();
        return $widget;
    }
}
