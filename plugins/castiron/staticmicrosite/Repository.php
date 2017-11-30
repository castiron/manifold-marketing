<?php namespace Castiron\StaticMicroSite;

class Repository
{

  public function __construct($configuration) {
    $this->configuration = $configuration;
  }

  private function path() {
    return $this->configuration->getContentRootPath();
  }

  private function target() {
    return $this->configuration->getTarget();
  }

  public function pull() {
    if (!$this->path() || !$this->target()) return null;
    $commands = [
      "cd ".$this->path()." && git fetch --all 2>&1",
      "cd ".$this->path()." && git reset --hard ".$this->target(),
      "cd ".$this->path()." && git rev-parse HEAD > revision.txt"
    ];
    $allOutput = [];
    $status = null;
    foreach($commands as $command) {
      $output = [];
      exec($command, $output, $status);
      $allOutput = array_merge($allOutput, $output);
      if ($status !== 0) break;
    }
    return $status;
  }

}
