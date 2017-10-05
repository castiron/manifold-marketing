<?php namespace Castiron\StaticMicrosite;

class StaticSiteConfiguration {

  /**
   * The root URL on the site for the serving of MD-source content, eg "docs"
   * @var string
   */
  protected $entryUrlPath = '';

  /**
   * The regex for the path to the file, eg "[A-Za-z_/]+"
   * @var string
   */
  protected $pathRegex = '';

  /**
   * Relative or absolute path to MD content, eg "/home/user/repos/content-repo/"
   * @var string
   */
  protected $contentRootPath = '';

  /**
   * @param $entryUrlPath string
   */
  public function setEntryUrlPath($entryUrlPath)
  {
    $this->entryUrlPath = $entryUrlPath;
  }

  /**
   * @return $entryPath string
   */
  public function getEntryUrlPath()
  {
    return $this->entryUrlPath;
  }

  /**
   * @param $pathRegex string
   */
  public function setPathRegex($pathRegex)
  {
    $this->pathRegex = $pathRegex;
  }

  /**
   * @return string
   */
  public function getPathRegex()
  {
    return $this->pathRegex;
  }

  /**
   * @param $contentRootPath string
   */
  public function setContentRootPath($contentRootPath)
  {
    $this->contentRootPath = $contentRootPath;
  }

  /**
   * @return string
   */
  public function getContentRootPath()
  {
    return $this->contentRootPath;
  }
}
