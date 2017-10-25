<?php namespace Castiron\Contentment\Controllers;

use Backend\Classes\FormTabs;
use Backend\Widgets\Form;
use BackendMenu;
use Backend\Classes\Controller;
use Castiron\Contentment\Models\Page;


/**
 * Pages Back-end Controller
 */
class Pages extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Owl.Behaviors.ListDelete.Behavior',
        'Backend.Behaviors.ImportExportController',
        'Backend.Behaviors.ReorderController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = ['castiron.contentment.access_pages'];

    /**
     * @param Form $form
     */
    public function formExtendFields(Form $form)
    {
        if (!Page::siteRootIsEnabled()) {
            $form->removeField('site_root');
        }

        if (!$this->user->hasAccess('castiron.contentment.access_simple_page_type')) {
            $form->removeField('simple_page_type');
        }

        if ($this->getModel() !== null && $this->getModel()->type === Page::TYPE_SIMPLE_PAGE) {
            if (strlen($this->getModel()->simple_page_type) > 0) {
                if (class_exists($this->getModel()->simple_page_type)) {
                    $configPath = $this->guessConfigPathFrom(str_replace('.', '\\', $this->getModel()->simple_page_type));
                    $config = $this->makeConfig($configPath . '/fields.yaml');
                    $jsonifiedConfig = $this->tweakConfig($config->fields);
                    $form->addFields($jsonifiedConfig, FormTabs::SECTION_PRIMARY, 'Content');
                }
            }
        }
    }

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Castiron.Contentment', 'pages', 'pages');

        $this->addCss('/plugins/castiron/contentment/assets/css/editor.css');
    }

    /**
     * @param $config
     * @param string $jsonFieldName
     * @return array
     */
    protected function tweakConfig($config, $jsonFieldName = 'data')
    {
        $jsonifiedConfig = [];
        foreach ($config as $fieldName => $fieldConfig) {
            $fieldConfig['trigger'] = ['action' => 'show', 'field' => 'type', 'condition' => 'value[2]'];
            $jsonifiedConfig[$jsonFieldName . '[' . $fieldName . ']'] = $fieldConfig;
        }
        return $jsonifiedConfig;
    }

    public function getModel()
    {
        if ($this->action != 'create') {
            $formWidget = $this->formGetWidget();
            if ($formWidget) {
                return $formWidget->model;
            }
        }
    }

    public function getPageUrl()
    {
        $model = $this->getModel();
        if ($model) {
            return $model->getUrl();
        }
    }

    public function renderBreadcrumb()
    {
        $model = $this->getModel();

        return $this->makePartial('breadcrumb', [
            'pageUrl' => $model->getUrl(),
            'title' => $model->title,
        ]);
    }
}
