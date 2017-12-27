<?php namespace Castiron\Manifold\Console;

use Castiron\Manifold\Services\Rss;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FetchRss extends Command {
  /**
   * @var string The console command name.
   */
  protected $name = 'rss:fetch';

  /**
   * @var string The console command description.
   */
  protected $description = 'Fetches all RSS feeds';

  /**
   * Execute the console command.
   * @return void
   */
  public function handle()
  {
    (new Rss())->fetchAll();
  }
}
