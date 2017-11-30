<?php namespace Castiron\StaticMicroSite;

use Illuminate\Http\Response as OctoberResponse;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Input;

class Webhook
{

  public function __construct($config) {
  	$this->config = $config;
  }

  public function respond() {
    $payload = Input::all();
//    $secret = $payload["hook"]["config"]["secret"];
    if (!$this->authorized($payload)) return $this->accessDenied();
    $status = $this->doUpdate();
    if ($status === 0) return $this->ok();
    return $this->inexplicableFailure();
  }


  public function authorized() {
    $sig = $_SERVER['HTTP_X_HUB_SIGNATURE'];
    $secret =  $this->config->getSecret();
    $check = 'sha1=' . hash_hmac('sha1', file_get_contents("php://input"), $secret, false);
    return $check == $sig;
  }
  
  protected function doUpdate() {
    $repository = new Repository($this->config);
    return $repository->pull();
  }

  protected function accessDenied() {
    $contents = 'Unauthorized access';
    $statusCode = 401;
    $response = new OctoberResponse;
    return new OctoberResponse($contents, $statusCode);
  }

  protected function inexplicableFailure() {
    $contents = 'Something went wrong';
    $statusCode = 500;
    $response = new OctoberResponse;
    return new OctoberResponse($contents, $statusCode);
  }

  protected function ok() {
    $contents = 'Documentation updated';
    $statusCode = 200;
    return new OctoberResponse($contents, $statusCode);
  }

}
