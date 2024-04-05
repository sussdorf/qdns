<?php

namespace Qdns;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Qdns\Exception\ParameterException;
use Qdns\Controller\ZoneController;

class ApiClient
{

    private string $apiToken;
    private string $apiUrl;
    private $httpClient;

    public function __construct(string $token, $httpClient = null, string $url)
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

        if (!is_array($params)) {
            throw new ParameterException();
        }

        $params['X-API-Key'] = $this->apiToken;

        switch ($method) {
            case 'GET':
                return $this->getApiClient()->get($url, [
                    'verify' => false,
                    'query' => $params,
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
        $result = json_decode($response);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $result;
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
}
