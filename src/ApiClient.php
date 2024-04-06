<?php

namespace Qdns;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Qdns\Exception\ParameterException;
use Qdns\Controller\ZoneController;
use Qdns\Controller\RecordController;

class ApiClient
{

    private string $apiToken;
    private string $apiUrl;
    private $httpClient;

    public function __construct(string $token, string $url, $httpClient = null,)
    {
        $this->apiToken = $token;
        $this->setApiClient($httpClient);
        $this->apiUrl = $url;
    }
    public function setApiClient(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client([
            'allow_redirects' => false,
            'follow_redirects' => false,
            'timeout' => 120,
            'http_errors' => false
        ]);
    }
    public function getApiClient(): Client
    {
        return $this->httpClient;
    }
    public  function canonical($name)
    {
        if (substr($name, -1) !== '.') {
            return $name . '.';
        }

        return $name;
    }
    private function callApi(string $actionPath, array $params = [], string $method = 'GET'): ResponseInterface
    {
        $url = $this->apiUrl . $actionPath;



        switch ($method) {
            case 'GET':
                return $this->getApiClient()->get($url, [
                    'verify' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'User-Agent' => 'Qdns-Client',
                        'X-API-Key' => $this->apiToken,
                    ],
                    'json' => $params,
                ]);
            case 'POST':
                return $this->getApiClient()->post($url, [
                    'verify' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'User-Agent' => 'Qdns-Client',
                        'X-API-Key' => $this->apiToken,
                    ],
                    'json' => $params,
                ]);
            case 'PUT':
                return $this->getApiClient()->put($url, [
                    'verify' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'User-Agent' => 'Qdns-Client',
                        'X-API-Key' => $this->apiToken,
                    ],
                    'json' => $params,
                ]);
            case 'DELETE':
                return $this->getApiClient()->delete($url, [
                    'verify' => false,
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Accept' => 'application/json',
                        'User-Agent' => 'Qdns-Client',
                        'X-API-Key' => $this->apiToken,
                    ],
                    'json' => $params,
                ]);
            default:
                throw new ParameterException('Wrong HTTP method passed');
        }
    }

    private function processRequest(ResponseInterface $response)
    {
        $response = $response->getBody()->__toString();

        if (json_last_error() == JSON_ERROR_NONE) {
            return $response;
        } else {
            return $response;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function get($actionPath, $params = [])
    {
        $response = $this->callApi($actionPath, $params, 'GET');

        return $this->processRequest($response);
    }

    /**
     * @throws GuzzleException
     */
    public function put($actionPath, $params = [])
    {
        $response = $this->callApi($actionPath, $params, 'PUT');

        return $this->processRequest($response);
    }
    /**
     * @throws GuzzleException
     */
    public function patch($actionPath, $params = [])
    {
        $response = $this->callApi($actionPath, $params, 'PUT');

        return $this->processRequest($response);
    }
    /**
     * @throws GuzzleException
     */
    public function post($actionPath, $params = [])
    {
        $response = $this->callApi($actionPath, $params, 'POST');

        return $this->processRequest($response);
    }

    /**
     * @throws GuzzleException
     */
    public function delete($actionPath, $params = [])
    {
        $response = $this->callApi($actionPath, $params, 'DELETE');

        return $this->processRequest($response);
    }

    private $zonecontroller;
    private $recordcontroller;
    /**
     * @return ZoneController
     */
    public function zone(): ZoneController
    {
        if (!$this->zonecontroller) {
            $this->zonecontroller = new ZoneController($this);
        }

        return $this->zonecontroller;
    }
    public function record(): RecordController
    {
        if (!$this->recordcontroller) {
            $this->recordcontroller = new RecordController($this);
        }

        return $this->recordcontroller;
    }
}
