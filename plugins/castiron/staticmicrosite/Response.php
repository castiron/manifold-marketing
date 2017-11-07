<?php namespace Castiron\StaticMicroSite;

use Castiron\StaticMicrosite\ResourceReader;
use Castiron\StaticMicrosite\Transformer;
use Cms\Classes\CmsException;
use Cms\Classes\Page;
use Cms\Classes\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response as OctoberResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class Response
{

  const PLUGIN_PATH = '../../../plugins/castiron/staticmicrosite/pages/two_column.htm';
  const TOC_FILE_NAME = '/SUMMARY.md';
  const DEFAULT_PAGE = 'README';
  const REVISION_FILE_NAME = 'revision.txt';

  public function __construct($config) {
    $this->config = $config;
    $this->resourceReader = new ResourceReader($this->config);
    $this->controller = new Controller;
    $this->basePath = $this->config->getEntryUrlPath();
    $this->currentRevision = $this->readRevision();
    $this->contentCache = null;
  }

  public function buildRoutes() {
    $this->buildRootRedirectRoute();
    $this->buildContentRoute();
  }

  private function buildRootRedirectRoute() {
    Route::get($this->basePath, function() {
      return new RedirectResponse($this->basePath.self::DEFAULT_PAGE, 301);
    });    
  }

  private function buildContentRoute() {
    $routeTmpl = $this->basePath.'/{path}';
    Route::get($routeTmpl, function ($path) {
      $this->resourceReader->path($path);
      return $this->respond($path);
    })->where('path', $this->config->getPathRegex());    
  }

  private function respond($path) {
    $page = $this->loadPage();
    if ($this->should404()) return $this->do404();
    if ($this->shouldReturnAsset()) return $this->doReturnAsset();
    if (!$page) return $this->throwPageNotFound();
    $this->assignControllerVars($path);
    $this->setPageTitle($page);
    return $this->controller->runPage($page);
  }

  private function readRevision() {
    $path = $this->config->getContentRootPath().'/'.self::REVISION_FILE_NAME;
    if (!file_exists($path)) return "";
    $content = file_get_contents($path);
    return $content;
  }

  private function setPath($path) {
    $this->path = $path;
  }

  private function should404() {
    return !$this->resourceReader->resourceExists() || false;
  }

  private function do404() {
    return OctoberResponse::make(View::make('cms::404'), '404');    
  }

  private function shouldReturnAsset() {
    return $this->resourceReader->isAsset();
  }

  private function doReturnAsset() {
    return OctoberResponse::file($this->resourceReader->getResolvedResourcePath());
  }

  private function loadPage() {
    return Page::load($this->controller->getTheme(), self::PLUGIN_PATH);
  }

  private function throwPageNotFound() {
    $type = 'cms::lang.page.not_found_name';
    $vars = ['name' => self::PLUGIN_PATH];
    throw new CmsException(Lang::get($type, $vars));
  }

  private function transformContent($path, $content) {
    $markdownTransformer = new Transformer($path, $this->basePath);
    return $markdownTransformer->transform($content);
  }

  private function getRequestContent() {
    if ($this->contentCache === null) {
      $this->contentCache = $this->resourceReader->getResourceContent();
    }
    return $this->contentCache;
  }

  private function transformedContent($path) {
    $cached = Cache::get($path);
    if ($cached && $cached['revision'] === $this->currentRevision) {
      return $cached['content'];
    } else {
      if ($cached) Cache::forget($path);
      $toCache = array(
        'revision' => $this->currentRevision,
        'content' => $this->transformContent($path, $this->getRequestContent())
      );
      Cache::forever($path, $toCache);
      return $toCache['content'];
    }
  }

  private function navigationStructure($requestPath) {
    $tocPath = $this->config->getContentRootPath().'/'.self::TOC_FILE_NAME;
    $navService = new Navigation($tocPath, $requestPath, $this->currentRevision);
    $navigation = $navService->buildTree();
    return $navigation;
  }

  private function assignControllerVars($path) {
    $this->controller->vars['content'] = $this->transformedContent($path);
    $this->controller->vars['navigation'] = $this->navigationStructure($path);
    $this->controller->vars['root'] = $this->basePath;
  }

  private function setPageTitle($page) {
    $content = $this->resourceReader->getResourceContent();
    if(preg_match('/^#(.*)$/m', $content, $matches)) {
      $page->title = trim($matches[1]);
    } else {
      $page->title = 'Manifold Documentation';
    }
  }

}
