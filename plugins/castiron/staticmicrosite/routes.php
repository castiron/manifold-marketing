<?php

use Castiron\StaticMicrosite\StaticSiteConfiguration as Config;
use Castiron\StaticMicrosite\StaticPageRequest as Request;
use Castiron\StaticMicrosite\MarkdownTransformer;
use Cms\Classes\CmsException;
use Cms\Classes\Page;
use October\Rain\Support\Facades\Markdown;

$config = new Config();
$config->setEntryUrlPath('docs');
$config->setPathRegex('[A-Za-z0-9_/\.\-]*');
$config->setContentRootPath('./storage/docs/manifold-docs');

Route::get($config->getEntryUrlPath().'/{path}', function ($path) use($config) {
  $request = new Request($config);
  $request->path($path);
  if($request->resourceExists()) {
    if($request->isAsset()) {
      return Response::file($request->getResolvedResourcePath());
    }
    $controller = new Cms\Classes\Controller();
    $pluginPath = '../../../plugins/castiron/staticmicrosite/pages/two_column.htm';
    if (($page = Page::load($controller->getTheme(), $pluginPath)) === null) {
      throw new CmsException(Lang::get('cms::lang.page.not_found_name', ['name' => $pluginPath]));
    }

    $content = $request->getResourceContent();
    $markdownTransformer = new MarkdownTransformer($path, $config->getEntryUrlPath());
    $controller->vars['content'] = Markdown::parse($markdownTransformer->transform($content));

    $markdownTransformer = new MarkdownTransformer('', $config->getEntryUrlPath());
    $controller->vars['navigation'] = Markdown::parse($markdownTransformer->transform(file_get_contents($config->getContentRootPath().'/SUMMARY.md')));

    // Naive implementation of page titling
    if(preg_match('/^#(.*)$/m', $content, $matches)) {
      $page->title = trim($matches[1]);
    } else {
      $page->title = 'Manifold Documentation';
    }

    return $controller->runPage($page);
  } else {
    return Response::make(View::make('cms::404'), '404');
  }
})->where('path', $config->getPathRegex());
