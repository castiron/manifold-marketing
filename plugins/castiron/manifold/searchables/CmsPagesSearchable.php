<?php namespace Castiron\Manifold\Searchables;

use Illuminate\Database\Query\Builder;
use URL;
use Queequeg\Contracts\Searchable;
// use Castiron\Contentment\Models\Page;
/**
 * Class CmsPagesSearchable
 * @package Castiron\Manifold\Searchables
 */
class CmsPagesSearchable implements Searchable
{
    const SLUGS = [
        'learn',
        'community',
        'resources',
        'services'
    ];

    /**
     * @return string
     */
    public static function beIcon() {
        return 'icon-files-o';
    }

    /**
     * @return string
     */
    public static function beKey() {
        return 'cmspages';
    }

    /**
     * @return string
     */
    public static function beSearchLabel() {
        return 'CMS Pages';
    }

    /**
     * @return mixed
     */
    public static function searchables()
    {
        return static::SLUGS;
    }

    /**
     * @param Searchable $instance
     * @return string
     */
    public static function singleViewURL($instance)
    {
        return URL::to($instance);
    }

    /**
     * @return bool
     */
    public function isSearchable() {
        return true;
    }

    /**
     * @param $record
     * @return string|int
     */
    public static function identifier($record) {
        return $record;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findBySearchIdentifier($id) {
        return $id;
    }
}
