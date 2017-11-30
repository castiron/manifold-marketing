<?php namespace Castiron\StaticMicrosite;

use Castiron\StaticMicrosite\Models\RouteSettings;

class Configuration {

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
   * @param $secret string
   */
  public function setSecret($secret)
  {
    $this->secret = $secret;
  }

  /**
   * @param $secret string
   */
  public function getSecret()
  {
    return $this->secret;
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
   * @param $targetstring
   */
  public function setTarget($target)
  {
    $this->target = $target;
  }

  public function getTarget()
  {
    return $this->target;
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

  public static function getByEntry($entry) {
    $routeSettings = RouteSettings::get('settings');
    if ($routeSettings === null) return null;
    foreach ($routeSettings as $route) {
      if ($route['entry_url_path'] === $entry) {
        return self::routeToConfig($route);
      }
    }
    return null;
  }

  public static function routeToConfig($route) {
      $config = new self();
      $config->setEntryUrlPath($route['entry_url_path']);
      $config->setPathRegex($route['path_regex']);
      $config->setSecret($route['secret']);
      $config->setTarget($route['repo']['branch_or_commit']);
      $config->setContentRootPath($route['repo']['content_root_path']);
      return $config;
  }

  # TODO: Add presence validation for these fields, dude
  public static function getAll() {
    $routeSettings = RouteSettings::get('settings');
    $configs = [];

    if ($routeSettings === null) return $configs;
    foreach ($routeSettings as $route) {
      array_push($configs, self::routeToConfig($route));
    }

    return $configs;
  }
}
