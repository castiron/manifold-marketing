<?php

namespace Castiron\Contentment\Content;

use Backend;
use Castiron\Contentment\Models\Content;
use Castiron\Contentment\Models\Page;
use Castiron\Peaches\Support\Arr;
use October\Rain\Support\Traits\Singleton;
use System\Classes\PluginManager;

class Manager
{
    use Singleton;

    protected static $defaultElementConfig = [
        'label' => '',
        'icon' => 'icon-anchor',
        'permissions' => [], // todo
        'category' => 'Standard',
        'position' => 0,
        'plugin' => 'Default',
    ];

    protected static $defaultSimplePageConfig = [
        'label' => '',
        'templates' => ['*']
    ];

    /** @var \System\Classes\PluginBase */
    protected $currentPlugin = null;
    protected $currentPluginName = null;
    protected $elementsByIdentifier = [];
    protected $simplePagesByIdentifier = [];
    protected $elementsByClass = [];
    protected $simplePagesByClass = [];
    protected $disabledElements = [];
    protected $disabledSimplePages = [];
    protected $overridingCategories = [];
    protected $categoryPositions = [];

    /**
     * Get available element types. If an ID is specified, then
     * only one element is returned. If no ID is specified, then
     * all elements are returned grouped by category.
     *
     * @param null $id
     * @return array
     */
    public function elements($id = null)
    {
        if (empty($this->elementsByIdentifier)) {
            $this->loadFromPlugins();
        }
        if ($id) {
            $element = Arr::safe($this->elementsByIdentifier, $id);
            if ($element) return $element;
            return Arr::safe($this->elementsByClass, $id);
        }
        return $this->elementsByCategory();
    }


    /**
     * Creates a new content record based on the element ID, page, and session key.
     *
     * @param string $elementIdentifier Like "Castiron.Contentment.Accordion" or something
     * @param Page $page The page this record is being added to (does not need to be saved yet)
     * @param string $sessionKey
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function makeContent($elementIdentifier, $page, $sessionKey)
    {
        $element = $this->elements($elementIdentifier);
        $c = Content::create(['element_type' => $element->class]);
        if ($page->id) {
            $page->contents()->add($c);
        } else {
            $page->contents()->add($c, $sessionKey);
        }

        return $c;
    }

    public static function registerSimplePage($class, $opts)
    {
        if (!new $class instanceof SimplePage) {
            throw new \Exception("Invalid simple page: '$class'. All registered content elements must implement Castiron\Contentment\Content\SimplePage.");
        }

        $options = Arr::defaults(static::$defaultSimplePageConfig, $opts);
        return static::instance()->addSimplePage($class, $options);
    }


    /**
     * Adds a new type to the dropdown list of available elements.
     *
     * @param string $class
     * @param array $opts
     * @return \stdClass
     * @throws
     */
    public static function registerElement($class, $opts)
    {
        if (!new $class instanceof Element) {
            throw new \Exception("Invalid content element: '$class'. All registered content elements must implement Castiron\Contentment\Content\Element.");
        }

        $options = Arr::defaults(static::$defaultElementConfig, $opts);
        return static::instance()->addElement($class, $options);
    }

    /**
     * Removes an Element from the dropdown list of available elements. Useful for
     * disabling or replacing Elements from other plugins.
     *
     * This works for elements that have not yet been registered as well.
     *
     * @param string $class
     */
    public static function disableElement($class)
    {
        static::instance()->removeElement($class);
    }

    /**
     * Allows you to sort categories
     *
     * @param string $category
     * @param int $position
     */
    public static function moveCategory($category, $position)
    {
        static::instance()->categoryPositions[$category] = $position;
    }

    /**
     * Before new pages are saved, users can still add content. If the page is
     * never saved, we'd have some orphaned records. This method deletes those
     * after they're a day old.
     */
    public static function clearDeferredContent()
    {
        $expired = new \DateTime();
        $expired->sub(new \DateInterval('P1D'));
        Content::where(['contentable_id' => null])->where('created_at', '<', $expired)->delete();
    }

    /**
     * @param $class
     * @param array $opts
     * @return \stdClass
     */
    protected function addSimplePage($class, array $opts)
    {
        // An array of templates this is allowed on
        $templates = (array)$opts['templates'];

        $id = $class;
        $obj = Arr::toStdClass($opts);
        $obj->templates = $templates;
        $obj->plugin = $this->currentPlugin->pluginDetails();
        $obj->class = $class;
        $obj->instance = new $class;
        $obj->id = $id;

        if (!isset($this->disabledSimpleages[$class])) {
            $this->simplePagesByIdentifier[$id] = $obj;
            $this->simplePagesByClass[$class] = $obj;
        }
        return $obj;
    }

    /**
     * Adds a new type to the dropdown list of available elements.
     *
     * @param string $class
     * @param array $opts
     * @return \stdClass
     * @throws \SystemException
     */
    protected function addElement($class, array $opts)
    {
        // Category comes from options unless someone has already
        // "moved" this class into a different category
        $category = Arr::safe($this->overridingCategories, $class, $opts['category']);

        // Easy string ID rather than always using class names
        $id = $this->currentPluginName . '.' . class_basename($class);

        $obj = Arr::toStdClass($opts);
        $obj->category = $category;
        $obj->plugin = $this->currentPlugin->pluginDetails();
        $obj->class = $class;
        $obj->instance = new $class;
        $obj->id = $id;

        if (!isset($this->disabledElements[$class])) {
            $this->elementsByIdentifier[$id] = $obj;
            $this->elementsByClass[$class] = $obj;
        }
        return $obj;
    }

    /**
     * Change the category (and/or position) for a certain element
     *
     * @param string $class
     * @param string $newCategory
     * @param int $position
     */
    public static function moveElement($class, $newCategory, $position = null)
    {
        $manager = static::instance();
        $manager->overridingCategories[$class] = $newCategory;
        if (!isset($manager->elementsByClass[$class])) return;
        $manager->elementsByClass[$class]->category = $newCategory;
        if ($position) {
            $manager->elementsByClass[$class]->position = $position;
        }
    }

    /**
     * Removes an Element from the dropdown list of available elements. Useful for
     * disabling or replacing Elements from other plugins.
     *
     * This works for elements that have not yet been registered as well.
     *
     * @param string $class
     */
    protected function removeElement($class)
    {
        if (isset($this->elementsByClass[$class])) {
            $element = $this->elementsByClass[$class];
            unset($this->elementsByIdentifier[$element->id]);
            unset($this->elementsByClass[$class]);
        }
        $this->disabledElements[$class] = $class;
    }

    /**
     * Returns an array where the elements are ready for display in dropdowns.
     *
     * @return array
     */
    protected function elementsByCategory()
    {
        $grouped = Arr::groupBy(Arr::sortBy($this->elementsByIdentifier, 'position'), 'category');
        ksort($grouped);
        if (count($this->categoryPositions)) {
            $newGrouped = [];
            $catMap = $this->categoryPositions;
            asort($catMap);
            foreach ($catMap as $category => $ignored) {
                $newGrouped[$category] = $grouped[$category];
                unset($grouped[$category]);
            }
            return array_merge($newGrouped, $grouped);
        }
        return $grouped;
    }

    /**
     * @return array
     */
    public function simplePages($template = null)
    {
        $simplePages = [];
        foreach ($this->simplePagesByIdentifier as $key => $config) {
            if ($template === null || $this->allowedTemplate($config->templates, $template)) {
                $simplePages[$key] = $config;
            }
        }
        return $simplePages;
    }

    protected function allowedTemplate($allowed, $toCheck)
    {
        return count(array_intersect($allowed, [$toCheck, '*'])) > 0;
    }

    /**
     * Loops through the plugins and calls the "registerContentElements" plugin.
     * Hopefully, that function does something useful like invoke our "registerElement" method.
     */
    protected function loadFromPlugins()
    {
        foreach (PluginManager::instance()->getPlugins() as $id => $plugin) {
            $this->currentPluginName = $id;
            $this->currentPlugin = $plugin;
            if (method_exists($plugin, 'registerContentElements')) {
                call_user_func([$plugin, 'registerContentElements']);
            }
        }
        $this->currentPluginName = null;
    }
}
