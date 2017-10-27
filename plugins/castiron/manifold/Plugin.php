<?php namespace Castiron\Manifold;

use Backend;
use System\Classes\PluginBase;
use Castiron\Manifold\Components\Navigation;
use Castiron\Manifold\Components\SearchResults;

use Castiron\Contentment\Content\Manager as ContentManager;
use Castiron\Manifold\Content\VideoHero;
use Castiron\Manifold\Content\ActionsListing;
use Castiron\Manifold\Content\AnimatedCallout;
use Castiron\Manifold\Content\Announcement;
use Castiron\Manifold\Content\DocumentationNav;
use Castiron\Manifold\Content\Faq;
use Castiron\Manifold\Content\FeaturedProjectHero;
use Castiron\Manifold\Content\MultiButtonCallout;
use Castiron\Manifold\Content\OneButtonCallout;
use Castiron\Manifold\Content\OneButtonHero;
use Castiron\Manifold\Content\ParallaxCallout;
use Castiron\Manifold\Content\ServicePackages;
use Castiron\Manifold\Content\Testimonials;
use Castiron\Manifold\Content\TwoColumnBlock;

use App;

use Queequeg\ServiceProvider as QueequegServiceProvider;
use Castiron\Manifold\Searchables\CmsPagesSearchable;
use Castiron\Search\Contracts\SearchQuery;
use Castiron\Search\Models\Query;

/**
 * manifold Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'manifold',
            'description' => 'Functionality for the Manifold Marketing Site',
            'author'      => 'castiron',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Initialize search functionality
     */
    protected function initSearch() {
        App::register(QueequegServiceProvider::class);

        $this->app->bind(SearchQuery::class, function ($app) {
            return new Query(function($index = 'manifold', $type = null) {
                if (!$index) {
                    $index = 'manifold';
                }
                if ($type) {
                    return "/search/$index/$type/_search";
                }
                return "/search/$index/_search";
            });
        });
    }

    /**
     * Register searchable models
     *
     * @return mixed
     */
    public function registerSearchables()
    {
        $models = [
            PagesSearchable::class
        ];

        foreach ($models as $m) {
            $types[$m::beKey()] = [
                'label'     => $m::beSearchLabel(),
                'icon'      => $m::beIcon(),
                'searchable'=> $m,
            ];
        }

        $out['manifold'] = [
            'icon'  => static::GENERAL_ICON,
            'label' => 'SITE SEARCH',
            'types' => $types,
        ];

        return $out;
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            Navigation::class => 'navigation'
        ];
    }

    /**
     * Registers any contentment components implemented in this plugin.
     *
     * @return array
     */
    public function registerContentElements()
    {
        ContentManager::registerElement(VideoHero::class, [
          'icon' => 'icon-video-camera',
          'label' => 'Video Hero',
          'position' => 100,
          'category' => 'Hero',
        ]);

        ContentManager::registerElement(OneButtonHero::class, [
          'icon' => 'icon-dot-circle-o',
          'label' => 'One Button Hero',
          'position' => 100,
          'category' => 'Hero',
        ]);

        ContentManager::registerElement(FeaturedProjectHero::class, [
          'icon' => 'icon-picture-o',
          'label' => 'Featured Project Hero',
          'position' => 100,
          'category' => 'Hero',
        ]);

        ContentManager::registerElement(AnimatedCallout::class, [
          'icon' => 'icon-film',
          'label' => 'Animated Callout',
          'position' => 100,
          'category' => 'Callout',
        ]);

        ContentManager::registerElement(Announcement::class, [
          'icon' => 'icon-bullhorn',
          'label' => 'Announcement',
          'position' => 100,
          'category' => 'Callout',
        ]);

        ContentManager::registerElement(MultiButtonCallout::class, [
          'icon' => 'icon-dot-circle-o',
          'label' => 'Multi-Button Callout',
          'position' => 100,
          'category' => 'Callout',
        ]);

        ContentManager::registerElement(OneButtonCallout::class, [
          'icon' => 'icon-dot-circle-o',
          'label' => 'One Button Callout',
          'position' => 100,
          'category' => 'Callout',
        ]);

        ContentManager::registerElement(ParallaxCallout::class, [
          'icon' => 'icon-arrows-v',
          'label' => 'Parallax Image Callout',
          'position' => 100,
          'category' => 'Callout',
        ]);

        ContentManager::registerElement(ActionsListing::class, [
          'icon' => 'icon-list-alt',
          'label' => 'Actions Listing',
          'position' => 100,
          'category' => 'Block',
        ]);

        ContentManager::registerElement(DocumentationNav::class, [
          'icon' => 'icon-search-plus',
          'label' => 'Documentation Navigation',
          'position' => 100,
          'category' => 'Block',
        ]);

        ContentManager::registerElement(Testimonials::class, [
          'icon' => 'icon-comments-o',
          'label' => 'Testimonials',
          'position' => 100,
          'category' => 'Block',
        ]);

        ContentManager::registerElement(Faq::class, [
          'icon' => 'icon-list',
          'label' => 'FAQs',
          'position' => 100,
          'category' => 'Block',
        ]);

        ContentManager::registerElement(ServicePackages::class, [
          'icon' => 'icon-list',
          'label' => 'Services',
          'position' => 100,
          'category' => 'Block',
        ]);

        ContentManager::registerElement(TwoColumnBlock::class, [
          'icon' => 'icon-newspaper-o',
          'label' => 'Two Column Block',
          'position' => 100,
          'category' => 'Block',
        ]);
    }

    /**
     * Registers backend permissions for this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
      return [
        'castiron.manifold.*' => [
          'label' => 'Manage the Manifold plugin',
          'tab' => 'Manifold',
        ],
        'castiron.news.*' => [
          'tab' => 'Castiron',
          'label' => 'Access News plugin'
        ],
      ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'manifold' => [
                'label'       => 'Manifold',
                'url'         => Backend::url('castiron/manifold/features'),
                'icon'        => 'icon-book',
                'permissions' => ['castiron.manifold.*'],
                'order'       => 500,
                'sideMenu'    => [
                  'features' => [
                       'label' => 'Features',
                       'icon'  => 'icon-check-circle-o',
                       'url'   => Backend::url('castiron/manifold/features')
                   ],
                   'feature_categories' => [
                        'label' => 'Feature Categories',
                        'icon'  => 'icon-list',
                        'url'   => Backend::url('castiron/manifold/featurecategories')
                    ],
                    'user_types' => [
                         'label' => 'User Types',
                         'icon'  => 'icon-users',
                         'url'   => Backend::url('castiron/manifold/usertypes')
                     ],
                ]
            ],
        ];
    }
}
