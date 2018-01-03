<?php namespace Castiron\StaticMicrosite;

use October\Rain\Support\Facades\Markdown;

class Transformer {
  /**
   * @var
   */
  protected $requestPath;

  /**
   *
   */
  protected $requestPathParent;

  /**
   * @var
   */
  protected $entryUrlPath;

  /**
   * MarkdownPathResolver constructor.
   * @param $requestPath
   * @param $entryUrlPath
   */
  public function __construct($requestPath, $entryUrlPath)
  {
    $this->requestPath = $requestPath;
    $this->entryUrlPath = $entryUrlPath;
    $this->requestPathParent = $this->getRequestPathParentFromPath($requestPath);
  }

  /**
   * @param $content
   */
  public function transform($markdown) {
    $adjustedMarkdown = $this->rewriteRelativePaths($markdown);
    return Markdown::parse($adjustedMarkdown);
  }

  /**
   * @param $path
   * @return string
   */
  private function getRequestPathParentFromPath($path) {
    $parts = array_filter(explode('/', $path));
    if(count($parts) == 0) {
      return '';
    } else {
      array_pop($parts);
      return join('/', $parts);
    }
  }

  /**
   *
   * @param $markdownContent
   * @return mixed
   */
  private function rewriteRelativePaths($markdownContent) {
//    return $markdownContent;
    return preg_replace_callback( '/\[(.*?)\]\((.*?)\)/', function ($matches) {
      if (strpos($matches[2], '://') !== false) {
        // External path, don't touch
        return $matches[0];
      } else {
        $startsWith = substr($matches[2],0,1);
        if($startsWith == '#') {
          $newUrl = $matches[2];
        } elseif($startsWith == '/') {
          // Absolute internal path
          $newUrl = $this->urlForPath('/'.$this->entryUrlPath.$matches[2]);
        } else {
          // Relative internal path
          $newUrl = $this->urlForPath('/'.$this->entryUrlPath.'/'.$this->requestPathParent.'/'.$matches[2]);
        }

        return '[' .$matches[1] . ']' . '(' . $newUrl. ')';
      }
    }, $markdownContent);
  }

  /**
   * Take a file reference from the markdown, and make it correct for rendering links or image references
   *
   * @param $path
   * @return string
   */
  private function urlForPath($path) {
    $fileInfo = pathinfo($path);
    if(array_key_exists('extension', $fileInfo)) {
      if(in_array($fileInfo['extension'], ['md', 'MD'])) {
        return $fileInfo['dirname'].'/'.$fileInfo['filename'];
      } else {
        return $path;
      }
    }
  }
}
