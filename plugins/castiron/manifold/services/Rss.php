<?php namespace Castiron\Manifold\Services;

use Carbon\Carbon;
use Castiron\Contentment\Models\Content;
use Illuminate\Support\Facades\Log;
use SimpleXmlElement;
use Cache;

class Rss
{
  public function fetchAll()
  {
    $contents = Content::where('element_type', 'Castiron\\Manifold\\Content\\Rss')->whereNull('deleted_at')->get();

    foreach ($contents as $content) {
      $element = $content->element();

      $data = Cache::get($element->getDataCacheKey());
      $refresh = Cache::get($element->getRefreshCacheKey());

      $now = Carbon::now();

      if (($data === null) OR ($refresh === null) OR ($now->gte($refresh))) {
        $posts = $this->getFeedData($element->feed_url, $element->num_items);

        if (count($posts)) {
          Cache::add($element->getDataCacheKey(), $posts, $element->getCacheMinutes());
          Cache::forever($element->getFallbackCacheKey(), $posts);
          Cache::add($element->getRefreshCacheKey(), Carbon::now()->addSeconds($element->getCacheMinutes() * .8 * 60), $element->getCacheMinutes());
        }
      }
    }
  }

  /**
   * @param $feedUrl
   * @param $itemCount
   * @return array
   */
  protected function getFeedData($feedUrl, $itemCount) {
    $posts = [];

    try {
      $content = file_get_contents($feedUrl);
      $x = new SimpleXmlElement($content);
      $posts = array();

      for ($i = 0; $i < $itemCount; $i++) {
        $post = $x->channel->item[$i];
        $postData = array(
          'link' => (string)$post->link,
          'title' => (string)$post->title,
          'description' => (string)$post->description
        );
        $posts[] = $postData;
      }
    } catch(\Exception $e) {
      Log::error("Failed to fetch RSS feed: $feedUrl ($itemCount items)", ['exception' => $e]);
    }
    return $posts;
  }
}
