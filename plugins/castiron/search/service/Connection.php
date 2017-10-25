<?php

namespace Castiron\Search\Service;

use Castiron\Search\Contracts\SearchQuery;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use October\Rain\Support\Traits\Singleton;

class Connection
{

    use Singleton;

    /** @var HttpClient */
    protected $client;

    /**
     * Connect here
     */
    protected function init()
    {

        $base = config('services.queequeg.host');
        $port = config('services.queequeg.port');
        $scheme = config('services.queequeg.scheme', 'http');
        if ($port) {
            $base .= ":$port";
        }
        if ($scheme) {
            $base = $scheme . '://' . $base;
        }

        $this->client = new HttpClient([
            'base_uri' => $base
        ]);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $opts
     * @return array [$result, $success]
     */
    public function request($method, $endpoint, $opts = [])
    {
        try {
            $r = $this->client->request($method, $endpoint, $opts);
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        return $r;
    }

    /**
     * @param SearchQuery $query
     * @return string
     */
    public function search(SearchQuery $query) {
        $res = $this->client->post($query->getEndpoint(), ['body' => $query->jsonSerialize()]);
        return $res->getBody()->getContents();
    }

    /**
     * @return HttpClient
     */
    public function getClient()
    {
        return $this->client;
    }

}
