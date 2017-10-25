<?php namespace Castiron\Contentment;

use Castiron\Contentment\Console\Scaffold\CreateElement;
use Castiron\Contentment\Content\Elements\Html;
use Castiron\Contentment\Content\Manager as ContentManager;
use Castiron\Contentment\Content\Elements\Image;
use Castiron\Contentment\Content\Elements\Text;
use Castiron\Contentment\Content\Pages\SampleHeaderTextImage;
use Castiron\Contentment\FormWidgets\Content as ContentWidget;
use Castiron\Contentment\FormWidgets\SimplePage as SimplePageWidget;
use Castiron\Contentment\FormWidgets\SimplePage;
use Castiron\Contentment\Models\Page;
use Event;
use App;
use Cms\Classes\Theme;
use Cms\Classes\Router;
use System\Classes\PluginBase;
use Backend;
use Castiron\Contentment\Models\Page as PageModel;
use Redirect;

/**
 * Content Plugin Information File
 */
class Plugin extends PluginBase
{


    public function registerNavigation()
    {
        return [
            'pages' => [
                'label' => 'Pages',
                'url' => Backend::url('castiron/contentment/pages'),
                'icon' => 'icon-files-o',
                'permissions' => ['castiron.contentment.*'],
                'order' => 20,

                'sideMenu' => [
                ]

            ]
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'content_page' => [PageModel::class, 'findByIdentifier'],
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'castiron.contentment.access_pages' => ['label' => 'Manage content pages', 'tab' => 'Castiron Pages'],
            'castiron.contentment.access_simple_page_type' => ['label' => 'Modify Simple Page select field', 'tab' => 'Castiron Pages'],
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('contentment.create.element', CreateElement::class);
    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Contentment',
            'description' => 'No description provided yet...',
            'author' => 'Castiron',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot()
    {
        Event::listen('cms.router.beforeRoute', function ($url) {
            $pageModel = PageModel::findByUrl($url);
            if ($pageModel && $pageModel->is_visible) {
                if ($pageModel->type == Page::TYPE_REDIRECT) {
                    header('Location: ' . $pageModel->redirect_url, true, 301);
                    exit;
                }

                $theme = Theme::getActiveTheme();
                $router = new Router($theme);
                $page = $router->findByUrl($router->findByFile($pageModel->template));
                $page->apiBag['pageModel'] = $pageModel;
                $page->title = $pageModel->title;
                $page->settings['title'] = $pageModel->title;
                $page->settings['url'] = $url;
                $page->settings['is_hidden'] = $page->hidden;
                return $page;
            }
        });

        Event::listen('cms.page.beforeRenderPage', function ($controller, $page) {
            if (!isset($page->apiBag['pageModel'])) {
                return;
            }
            $pageModel = $page->apiBag['pageModel'];
            $controller->vars['pageModel'] = $pageModel;
        });

        Event::listen('backend.form.extendFieldsBefore', function ($formWidget) {
            if ($formWidget->model instanceof \Cms\Classes\Page) {
                PageModel::extendCmsPageForm($formWidget);
            }
        });

        if (App::runningInBackend()) {
            // todo this can go somewhere else
            ContentManager::clearDeferredContent();
        }

    }

    public function registerFormWidgets()
    {
        return [
            ContentWidget::class => ['code' => 'page-contents'],
            SimplePageWidget::class => ['code' => 'simple-page-contents'],
        ];
    }

    public function registerContentElements()
    {
        ContentManager::registerElement(Text::class, [
            'icon' => 'icon-paragraph',
            'label' => 'Text',
        ]);
        ContentManager::registerElement(Image::class, [
            'icon' => 'icon-picture-o',
            'label' => 'Image',
        ]);
        ContentManager::registerElement(Html::class, [
            'icon' => 'icon-code',
            'label' => 'HTML',
        ]);
        ContentManager::registerSimplePage(SampleHeaderTextImage::class, [
            'templates' => ['*'],
            'label' => 'Sample Header / Text / Image'
        ]);
    }

}
