<?php namespace Castiron\Manifold\Searchables;

use Castiron\StaticMicrosite\MarkdownTransformer;
use Illuminate\Support\Facades\Storage;
use URL;
use Queequeg\Contracts\Searchable;

/**
 * Class DocsSearchable
 * @package Castiron\Manifold\Searchables
 */
class DocsSearchable implements Searchable
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
    return 'docs';
  }

  /**
   * @return string
   */
  public static function beSearchLabel() {
    return 'Manifold Docs';
  }

  /**
   * @return mixed
   */
  public static function searchables()
  {
    $directory = '/manifold-docs/contents';
    $files = Storage::disk('docs')->allFiles($directory);

    $urls = [];
    foreach ($files as $file) {
      $urls[] = self::urlizeFilePath($file);
    }
    return $urls;
  }

  /**
   * @param $file
   * @return string
   */
  public static function urlizeFilePath($file)
  {
    $pathParts = explode('/', $file);
    array_shift($pathParts);
    array_unshift($pathParts, 'docs');
    return MarkdownTransformer::urlForPath(implode('/', $pathParts));
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
