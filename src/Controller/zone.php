<?php

namespace Qdns\Controller;

use Qdns\ApiClient;
use Qdns\Helper;
use Qdns\APIResponse;

class ZoneController
{
    private $apiclient;

    public function __construct(ApiClient $apiclient)
    {
        $this->apiclient = $apiclient;
    }

    /*
        List all Zones from given Server

        @return as json Object 
    */
    public function listZones()
    {
        $response = $this->apiclient->get('/api/v1/servers/localhost/zones');
        return new APIResponse($response);
    }
    /*
        List a single  Zones from given Server

        @return as json Object 
    */
    public function listZone($zone)
    {
        $response = $this->apiclient->get('/api/v1/servers/localhost/zones/' . Helper::canonical($zone));
        return new APIResponse($response);
    }
    /*
        Delete a single  Zones from given Server

        @return a no content
    */
    public function deleteZone($zone)
    {
        $response = $this->apiclient->delete('/api/v1/servers/localhost/zones/' . Helper::canonical($zone));
        return new APIResponse($response);
    }
}
