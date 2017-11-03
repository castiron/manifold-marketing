<?php namespace Castiron\Manifold\StaticMicroSite;

use Castiron\StaticMicrosite\StaticPageRequest as Request;
use Castiron\StaticMicrosite\MarkdownTransformer;
use Cms\Classes\CmsException;
use Cms\Classes\Page;
use Cms\Classes\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use October\Rain\Support\Facades\Markdown;
use Illuminate\Support\Facades\Route;

class ManifoldDocs
{

  const PLUGIN_PATH = '../../../plugins/castiron/staticmicrosite/pages/two_column.htm';
  const TOC_FILE_NAME = '/SUMMARY.md';

  public function __construct($config) {
    $this->config = $config;
    $this->request = new Request($this->config);
    $this->controller = new Controller;
    $this->basePath = $this->config->getEntryUrlPath();
    $this->contentCache = null;
  }

  public function build() {
    $routeTmpl = $this->basePath.'/{path}';
    Route::get($routeTmpl, function ($path) {
      $this->request->path($path);
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

  private function setPath($path) {
    $this->path = $path;
  }

  private function should404() {
    return !$this->request->resourceExists() || false;
  }

  private function do404() {
    return Response::make(View::make('cms::404'), '404');    
  }

  private function shouldReturnAsset() {
    return $this->request->isAsset();
  }

  private function doReturnAsset() {
    return Response::file($this->request->getResolvedResourcePath());
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
    $markdownTransformer = new MarkdownTransformer($path, $this->basePath);
    return Markdown::parse($markdownTransformer->transform($content));
  }

  private function getRequestContent() {
    if ($this->contentCache === null) {
      $this->contentCache = $this->request->getResourceContent();
    }
    return $this->contentCache;
  }

  private function transformedContent($path) {
    return $this->transformContent($path, $this->getRequestContent());
  }

  private function navigationStructure() {
    $path = $this->config->getContentRootPath().'/'.self::TOC_FILE_NAME;
    $content = file_get_contents($path);
    return $this->transformContent('', $content);
  }

  private function assignControllerVars($path) {
    $this->controller->vars['content'] = $this->transformedContent($path);
    $this->controller->vars['navigation'] = $this->navigationStructure();
    $this->controller->vars['root'] = $this->basePath;
  }

  private function setPageTitle($page) {
    $content = $this->request->getResourceContent();
    if(preg_match('/^#(.*)$/m', $content, $matches)) {
      $page->title = trim($matches[1]);
    } else {
      $page->title = 'Manifold Documentation';
    }
  }

}
