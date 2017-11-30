<?php namespace Castiron\StaticMicroSite;

use Illuminate\Support\Facades\Response as OctoberResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class Webhook
{

  public function __construct($config) {
  	$this->config = $config;
  }

  public function respond() {
    $payload = Input::all();
    $secret = $payload["hook"]["config"]["secret"];
    if ($secret !== $this->config->getSecret()) return $this->accessDenied();
    $status = $this->doUpdate();
    if ($status === 0) return $this->ok();
    return $this->inexplicableFailure();
  }

  protected function doUpdate() {
    $repository = new Repository($this->config);
    return $repository->pull();
  }

  protected function accessDenied() {
    $contents = 'Unauthorized access';
    $statusCode = 401;
    return OctoberResponse::make($contents, $statusCode);
  }

  protected function inexplicableFailure() {
    $contents = 'Something went wrong';
    $statusCode = 500;
    return OctoberResponse::make($contents, $statusCode);
  }

  protected function ok() {
    $contents = 'Documentation updated';
    $statusCode = 200;
    return OctoberResponse::make($contents, $statusCode);
  }

}
