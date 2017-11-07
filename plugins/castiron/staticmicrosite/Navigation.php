<?php namespace Castiron\StaticMicroSite;

class Navigation
{

  public function __construct($path, $requestPath, $revision) {
    $this->path = $path;
    $this->requestPath = $requestPath;
    $this->revision = $revision;
    $this->rawLines = $this->readRawLines();
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
  }

  private function setActiveStates($tree) {
    foreach($tree as $leaf) {
      $this->setActiveStatesRecursive($leaf);
    }
  }

  public function buildTree() {
    foreach ($this->rawLines as $index => $line) {      
      $leaf = $this->lineToLeaf($line);
      $level = $leaf->level;
      $this->pointers[$level - 1]->children[] = $leaf;
      $this->pointers[$level] = $leaf;
    }
    // This could be cached.
    $tree = $this->pointers[0]->children;
    $this->setActiveStates($tree);
    return $tree;
  }
}
