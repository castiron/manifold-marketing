<?php namespace Castiron\Manifold\Searchables;

use Illuminate\Database\Query\Builder;
use URL;
use Queequeg\Contracts\Searchable;
use Castiron\Contentment\Models\Page;

/**
 * Class PagesSearchable
 * @package Castiron\Forth\Searchables
 */
class PagesSearchable implements Searchable
{

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
    return 'pages';
  }

  /**
   * @return string
   */
  public static function beSearchLabel() {
    return 'Content Pages';
  }

  /**
   * @return mixed
   */
  public static function searchables()
  {
    return Page::visible()->where('type', '!=', Page::TYPE_REDIRECT)->get();
  }

  /**
   * @param Searchable $instance
   * @return string
   */
  public static function singleViewURL($instance)
  {
    return URL::to($instance->getUrl());
  }

  /**
   * @return bool
   */
  public function isSearchable() {
    return true;
  }

  /**
   * Get all records that are searchable
   *
   * @param Builder $query
   */
  public function scopeSearchable($query)
  {
    return $this->scopeVisible($query);
  }

  /**
   * @param $record
   * @return string|int
   */
  public static function identifier($record) {
    return $record->id;
  }

  /**
   * @param $id
   * @return mixed
   */
  public static function findBySearchIdentifier($id) {
    return static::find($id);
  }
}
