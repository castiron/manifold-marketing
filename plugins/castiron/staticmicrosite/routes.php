<?php

use Castiron\StaticMicrosite\StaticSiteConfiguration as Config;
use Castiron\Manifold\StaticMicroSite\ManifoldDocs;


App::before(function() {
  $configs = Config::getAll();
  foreach ($configs as $config) {
  	(new ManifoldDocs($config))->buildRoutes();
  }
});

