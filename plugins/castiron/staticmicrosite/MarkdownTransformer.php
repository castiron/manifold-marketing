<?php namespace Castiron\StaticMicrosite;

class MarkdownTransformer {
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
   * @param $path
   * @return string
   */
  public function getRequestPathParentFromPath($path) {
    $parts = array_filter(explode('/', $path));
    if(count($parts) == 0) {
      return '';
    } else {
      array_pop($parts);
      return join('/', $parts);
    }
  }


  /**
   * @param $content
   */
  public function transform($content) {
    return $this->resolveAllPaths($content);
  }

  /**
   *
   * @param $markdownContent
   * @return mixed
   */
  protected function resolveAllPaths($markdownContent) {
    return preg_replace_callback( '/\[(.*?)\]\((.*?)\)/', function ($matches) {
      if (strpos($matches[2], '://') !== false) {
        // External path, don't touch
        return $matches[0];
      } else {
        if(substr($matches[2],0,1) == '/') {
          // Absolute internal path
          $newUrl = $matches[2];
        } else {
          // Relative internal path
          $newUrl = '/'.$this->requestPathParent.$matches[2];
        }

        return '[' .$matches[1] . ']' . '(' . $this->urlForPath('/'.$this->entryUrlPath.$newUrl). ')';
      }
    }, $markdownContent);
  }

  /**
   * Take a file reference from the markdown, and make it correct for rendering links or image references
   *
   * @param $path
   * @return string
   */
  protected function urlForPath($path) {
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
