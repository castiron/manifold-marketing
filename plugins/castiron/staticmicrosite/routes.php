<?php

use Castiron\StaticMicrosite\Configuration;
use Castiron\StaticMicroSite\Response;

App::before(function() {
  $allConfig = Configuration::getAll();
  foreach ($allConfig as $siteConfig) {
  	(new Response($siteConfig))->buildRoutes();
  }
});

