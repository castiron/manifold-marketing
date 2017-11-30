<?php

use Castiron\StaticMicrosite\Configuration;
use Castiron\StaticMicroSite\Response;
use Castiron\StaticMicroSite\Webhook;

App::before(function() {
  $allConfig = Configuration::getAll();

  foreach ($allConfig as $siteConfig) {
  	(new Response($siteConfig))->buildRoutes();
  }

  Route::post('/static/microsite/{entry}/webhook', function ($entry) {
  	$config = Configuration::getByEntry($entry);
  	$webhook = new Webhook($config);
  	return $webhook->respond();
  });

});

