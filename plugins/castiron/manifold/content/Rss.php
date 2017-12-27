<?php

namespace Castiron\Manifold\Content;

use Carbon\Carbon;
use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Traits\Twiggable;
use Cache;

/**
 * Rss Element
 */
class Rss extends Element
{
  const CACHE_KEY_PREPEND = 'rss-feed';
  const CACHE_MINUTES = 360;
  use Twiggable;

  public function getRssFeed()
  {
    $posts = Cache::get($this->getDataCacheKey());

    $fallback = false;
    if($posts === null) {
      $fallback = true;
      $posts = Cache::get($this->getFallbackCacheKey());
    }

    $expiration = Cache::get($this->getRefreshCacheKey());

    $diffString = 'expired';

    $now = Carbon::now();
    if ($expiration !== null AND $expiration->gte($now)) {
      $diffString = $expiration->diffInSeconds(Carbon::now());
    }
    return ['posts' => $posts, 'refresh' => $diffString, 'fallback' => $fallback];
  }

  /**
   * @return string
   */
  public function getDataCacheKey()
  {
    return self::CACHE_KEY_PREPEND . '-' . $this->id;
  }

  /**
   * @return string
   */
  public function getRefreshCacheKey()
  {
    return self::CACHE_KEY_PREPEND . '-refresh-' . $this->id;
  }

  /**
   * @return string
   */
  public function getFallbackCacheKey()
  {
    return self::CACHE_KEY_PREPEND . '-fallback-' . $this->id;
  }

  /**
   * @return int
   */
  public function getCacheMinutes()
  {
    return self::CACHE_MINUTES;
  }
}
