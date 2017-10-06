<?php namespace Castiron\StaticMicrosite;

class StaticPageRequest
{
  /**
   * @var StaticSiteConfiguration
   */
  protected $staticSiteConfiguration;

  /**
   * @var array
   */
  protected $resourcePathOptions = [];

  /**
   * @var string
   */
  protected $resolvedResourcePath = '';

  /**
   * @var
   */
  protected $path;

  /**
   * @var boolean
   */
  protected $isAsset;

  /**
   * StaticPageRequest constructor.
   * @param StaticSiteConfiguration $staticSiteConfiguration
   */
  public function __construct(StaticSiteConfiguration $staticSiteConfiguration)
  {
    $this->staticSiteConfiguration = $staticSiteConfiguration;
  }

  /**
   * @param $path string
   */
  public function path($path)
  {
    $this->path = $this->sanitizePath($path);

    $pathInfo = pathinfo($this->path);
    $extension = array_key_exists('extension', $pathInfo) ? $pathInfo['extension'] : '';

    $this->resourcePathOptions = $this->fileLocationOptions(
      $this->getContentRootPath(),
      $this->path,
      $extension
    );
  }

  public function sanitizePath($path)
  {
    return $path;

  }

  protected function getContentRootPath()
  {
    return $this->staticSiteConfiguration->getContentRootPath();
  }

  /**
   * @return bool
   */
  public function resourceExists()
  {
    if(strlen($this->resolvedResourcePath) > 0) return true;
    return $this->resolvePath();
  }

  public function validateResourcePath($path) {
    return !preg_match('/\.\//', $path);
  }

  /**
   * @return bool
   */
  public function resolvePath()
  {
    foreach($this->resourcePathOptions as $option) {
      if(file_exists($option)) {
        $this->resolvedResourcePath = $option;
        return true;
      }
    }
    return false;
  }

  public function getResolvedResourcePath() {
    $this->resolvePath();
    return $this->resolvedResourcePath;
  }


  /**
   * @return bool|string
   */
  public function getResourceContent()
  {
    if($this->resourceExists()) {
      return file_get_contents($this->resolvedResourcePath);
    }
  }

  protected function fileLocationOptions($contentPath, $requestPath, $ext) {
    if (!$this->validateResourcePath($requestPath)) return []; // If the request path fails validation, don't return any locations
    switch(strtolower($ext)) {
      case '':
        $this->isAsset = false;
        return $this->markdownFileLocationOptions($contentPath, $requestPath);
      break;

      default:
        $this->isAsset = true;
        return $this->assetFileLocationOptions($contentPath, $requestPath);
      break;
    }
  }

  protected function assetFileLocationOptions($contentPath, $requestPath)
  {
    return [$contentPath.'/'.$requestPath];
  }

  public function isAsset()
  {
    return $this->isAsset;
  }

  /**
   * @param $contentPath
   * @param $requestPath
   * @return array
   */
  protected function markdownFileLocationOptions($contentPath, $requestPath)
  {
    return [$contentPath.'/'.$requestPath.'.md', $contentPath.'/'.$requestPath.'.MD', $contentPath.'/README.md', $contentPath.'/README.MD'];
  }
}
