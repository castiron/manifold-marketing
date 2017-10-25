<?php namespace Castiron\Contentment\Models;

use Castiron\Contentment\Content\Pages\SampleHeaderTextImage;
use Castiron\Contentment\Traits\Aliasable;
use Castiron\Contentment\Traits\SemanticUrlable;
use Castiron\Lib\Traits\Visible;
use Castiron\Peaches\Support\Arr;
use Model;
use Lang;
use Cms\Classes\Theme;
use Cms\Classes\Page as CmsPage;
use Castiron\Contentment\Content\Manager as ContentManager;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\NestedTree;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;
use Castiron\Lib\Contracts\Visible as VisibleContract;
use October\Rain\Support\Facades\Config;
use Request;
use System\Traits\ConfigMaker;

/**
 * Page Model
 */
class Page extends Model implements VisibleContract
{

    use Sluggable;
    use SoftDelete;
    use Validation;
    use NestedTree;
    use Aliasable;
    use SemanticUrlable {
        findByUrl as traitFindByUrl;
        getUrl as traitGetUrl;
    }
    use Visible;
    use ConfigMaker;

    const TYPE_CONTENT = 0;
    const TYPE_REDIRECT = 1;
    const TYPE_SIMPLE_PAGE = 2;

    public $rules = [
        'title' => 'required',
        'slug' => 'required_if:site_root,0',
        'reference' => 'unique:castiron_contentment_pages,reference',
        'template' => 'required',
        'site_root' => 'unique:castiron_contentment_pages,site_root,NULL,id,site_root,1'
    ];

    /**
     * @var string Field used by the aliasable trait
     */
    protected $aliasField = 'reference';

    /**
     * @var string Field used by the semanticurlable trait for path segment value
     */
    protected $segmentField = 'slug';

    /**
     * @var string Field used by the semanticurlable trait for the field that refers to the parent
     */
    protected $parentIdField = 'parent_id';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'castiron_contentment_pages';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['url', 'data', 'title', 'slug', 'template', 'navigation_title', 'parent_id', 'is_hidden', 'reference', 'type', 'redirect_url', 'site_root'];

    protected $slugs = [
        'slug' => 'title'
    ];

    protected $jsonable = [
        'content', 'data'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];

    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'contents' => [Content::class, 'name' => 'contentable']
    ];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * @return array
     */
    public function getTypeOptions()
    {
        return [
            self::TYPE_CONTENT => 'Content Page',
            self::TYPE_REDIRECT => 'Redirect Page',
            self::TYPE_SIMPLE_PAGE => 'Simple Page',
        ];
    }

    /**
     * @return array
     */
    public function getSimplePageTypeOptions()
    {
        $contentManager = ContentManager::instance();
        return array_map(function ($i) {
            return $i->label;
        }, $contentManager->simplePages($this->template));
    }

    /**
     * A scope that returns only pages that have 'site_root' set on them.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSiteRoot(Builder $query)
    {
        if (!static::siteRootIsEnabled()) {
            return $query->whereRaw('1 != 1');
        }
        return $query->where('site_root', 1);
    }

    /**
     * @return bool
     */
    public static function siteRootIsEnabled()
    {
        return Config::get('castiron.contentment::enableSiteRoot');
    }

    /**
     * Given a URL and an array of relevant scopes, finds the referred to model.
     * @param $url
     * @return null
     */
    public static function findByUrl($url, $scopes = [])
    {
        /**
         * Are we looking for the page flagged as site root?
         */
        if ($url === '/' && $page = static::siteRoot()->first()) {
            return $page;
        }

        if ($page = static::traitFindByUrl($url, $scopes)) {
            /**
             * We don't want the site root to show up under an alternate path,
             * in the case that it was found by (irrelevent) slug
             */
            if ($url !== '/' && !$page->site_root) {
                return $page;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    protected function siteRootUrl()
    {
        return '/';
    }

    /**
     * Helper method for getting the URL
     * @return null|string
     */
    public function getUrl()
    {
        if ($this->site_root) {
            return $this->siteRootUrl();
        }
        return $this->traitGetUrl();
    }

    /**
     * @param null|int $val
     * @return null|int
     */
    public function getSiteRootAttribute($val)
    {
        return static::siteRootIsEnabled() ? $val : null;
    }

    /**
     * @return mixed
     */
    public function getVisibleChildren()
    {
        return $this->children()->visible()->get();
    }

    /**
     * If content blocks don't have a section_title, then we don't render it in the menu.
     *
     * @param bool $anchorableOnly
     * @deprecated
     * @return array
     */
    public function getContentHeaders($anchorableOnly = true)
    {
        $headers = [];
        $content = $this->content;
        if (!isset($content) || !is_array($content)) return [];

        foreach ($content as $block) {
            if ($anchorableOnly && isset($block['section_not_anchor']) && $block['section_not_anchor']) {
                continue;
            }
            if (trim($block['section_title'])) {
                $headers[] = $block['section_title'];
            }
        }

        return $headers;
    }

    /**
     * @return array
     */
    public function getContentElements()
    {
        return $this->contents()->ordered()->visible()->get()->all();
    }

    /**
     * @param string $glue
     * @return string
     */
    public function renderContent($glue = "\n")
    {
        $rendered = Arr::mapMethod($this->getContentElements(), 'render');
        return implode($glue, $rendered);
    }


    /**
     * Get all the "elements" by the type. This returns
     * the pseudo model, Element. Not the actual Content model.
     *
     * @param string|array $elementIdentifiers Like "Castiron.Moca.Section" to get the section elements
     * @return array
     */
    public function elementsByTypes($elementIdentifiers)
    {
        if (!is_array($elementIdentifiers)) {
            $elementIdentifiers = func_get_args();
        }
        $types = [];
        foreach ($elementIdentifiers as $id) {
            $elementInfo = ContentManager::instance()->elements($id);
            $types[] = $elementInfo->class;
        }
        $contents = $this->contents()->ordered()->visible()->whereIn('element_type', $types)->get()->all();
        return Arr::mapMethod($contents, 'element');
    }

    /**
     * @param string $elementIdentifier Like "Castiron.Moca.Section" to get the section elements
     * @return array
     */
    public function elementsByType($elementIdentifier)
    {
        return $this->elementsByTypes($elementIdentifier);
    }

    /**
     * Do some validation of content blocks before rendering them.
     *
     * @return array
     * @deprecated
     */
    public function getValidContentBlocks()
    {
        $blocks = [];
        $content = $this->content;
        if (!isset($content) || !is_array($content)) return [];
        foreach ($content as $block) {

            $block['no_content'] = false;

            if ($block['type'] == 'richeditor') {
                // Let's make sure our content doesn't just consist of empty "<p></p>" tags.
                $val = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', strip_tags($block['section_content']));
                if (!$val) {
                    $block['no_content'] = true;
                }
            }

            $blocks[] = $block;
        }
        return $blocks;
    }

    /**
     * @param $identifier
     * @return Page
     */
    public static function findByIdentifier($identifier)
    {
        $page = self::find($identifier);
        if (!$page) {
            $page = self::findByUrl($identifier);
        }

        return $page;
    }

    /**
     * @return array
     */
    public function getTemplateOptions()
    {
        if (!($theme = Theme::getEditTheme())) {
            throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
        }

        $pages = CmsPage::listInTheme($theme, true);
        $result = [];
        foreach ($pages as $page) {
            if (!array_key_exists('is_content_page', $page['settings']) || !$page['settings']['is_content_page']) continue;
            $baseName = $page->getBaseFileName();
            $result[$baseName] = $page->title;
        }

        return $result;
    }

    /**
     * @param $formWidget
     */
    public static function extendCmsPageForm($formWidget)
    {
        $fieldConfig = [
            'tab' => 'cms::lang.editor.settings',
            'type' => 'checkbox',
            'label' => 'Is Content Page Template',
            'comment' => 'Check this to make this page available as a template for content editors.'

        ];
        $formWidget->tabs['fields']['settings[is_content_page]'] = $fieldConfig;
    }

    /**
     * @return mixed|null
     */
    public static function currentPage()
    {
        return self::findByUrl(Request::path());
    }

}
