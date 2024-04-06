<?php

namespace Qdns\Controller;

use Qdns\ApiClient;
use Qdns\Helper;


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
        return $this->apiclient->get('api/v1/servers/localhost/zones');
    }
    /*
        List a single  Zones from given Server

        @return as json Object 
    */
    public function listZone($zone)
    {

        return $this->apiclient->get('api/v1/servers/localhost/zones/' . Helper::canonical($zone));
    }
    /*
        Delete a single  Zones from given Server

        @return a no content
    */
    public function deleteZone($zone)
    {

        return $this->apiclient->delete('api/v1/servers/localhost/zones/' . Helper::canonical($zone));
    }
}
