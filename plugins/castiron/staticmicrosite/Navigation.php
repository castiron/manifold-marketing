<?php namespace Castiron\StaticMicroSite;

class Navigation
{

  public function __construct($path, $requestPath, $revision) {
    $this->path = $path;
    $this->requestPath = $requestPath;
    $this->revision = $revision;
    $this->rawLines = $this->readRawLines();
    $this->pagination = array();
    $this->breadcrumbs = array();
    $rootLeaf = new \stdClass();
    $rootLeaf->url = "";
    $rootLeaf->level = 0;
    $rootLeaf->children = array();
    $this->pointers = ['last'=> $rootLeaf, '0' => $rootLeaf];
  }

  private function readRawLines() {
    $content = file($this->path);
    $lines = array();
    foreach ($content as $line) {
      $firstChar = substr(trim($line), 0, 1);
      if ($firstChar !== "*") continue;
      $lines[] = $line;
    }
    return $lines;
  }

  private function lineToLeaf($line) {
    if(!$line) return $line;
    $level = (strlen($line)-strlen(ltrim($line))) / 2;
    $leaf = new \stdClass();
    $leaf->title = $this->titleFromLine($line);
    $leaf->path = $this->urlFromLine($line);
    $leaf->active = false;
    $leaf->directory = dirname($leaf->path);
    $leaf->level = $level + 1;
    $leaf->children = array();
    return $leaf;
  }

  private function titleFromLine($line) {
    preg_match('/\[(.*)\]/', $line, $match);
    return $match[1];
  }

  private function urlFromLine($line) {
    preg_match('/\((.*?)\)/', $line, $match);
    return str_replace('.md', '', $match[1]);
  }

  private function setActiveStatesRecursive($leaf) {
    if (substr($this->requestPath, 0, strlen($leaf->directory)) == $leaf->directory) {
      if ($leaf->children || $this->requestPath === $leaf->path) $leaf->active = true;
      if ($leaf->children) {
        foreach($leaf->children as $child) {
          $this->setActiveStatesRecursive($child);
        }
      }
    }

    if ($leaf->active === true) {
      $this->setBreadcrumbs($leaf);
    }
  }

  private function setActiveStates($tree) {
    foreach($tree as $leaf) {
      $this->setActiveStatesRecursive($leaf);
    }
  }

  private function getPagination($currentLeaf, $currentIndex) {
    $previous = ($currentIndex > 0 ? $this->rawLines[$currentIndex - 1] : null);
    $next = ($currentIndex < (count($this->rawLines) - 1) ? $this->rawLines[$currentIndex + 1] : null);
    return array($this->lineToLeaf($previous), $this->lineToLeaf($next));
  }

  private function setBreadcrumbs($leaf) {
    array_unshift($this->breadcrumbs, $leaf);
  }

  public function buildTree() {
    foreach ($this->rawLines as $index => $line) {
      $leaf = $this->lineToLeaf($line);
      $level = $leaf->level;
      $this->pointers[$level - 1]->children[] = $leaf;
      $this->pointers[$level] = $leaf;

      if ($this->requestPath === $leaf->path) {
        $this->pagination = $this->getPagination($leaf, $index);
      }
    }
    // This could be cached.
    $tree = $this->pointers[0]->children;
    $this->setActiveStates($tree);
    return $tree;
  }

  public function buildNavs() {
    $tree = $this->buildTree();
    $navs = new \stdClass();
    $navs->pages = $tree;
    $navs->breadcrumbs = $this->breadcrumbs;
    $navs->pagination = $this->pagination;
    return $navs;
  }
}
