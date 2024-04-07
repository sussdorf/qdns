<?php

namespace Qdns\Controller;

use Qdns\ApiClient;
use Qdns\Helper;


class RecordController
{
    private $apiclient;

    public function __construct(ApiClient $apiclient)
    {
        $this->apiclient = $apiclient;
    }

    /*
        Add Record to given Zone

        @return as json Object 
    */

    public function addRecord($zone, $name, $type, $ttl, $content)
    {
        $param = [
            'rrsets' => [
                [
                    'name' => $name . '.',
                    'type' => $type,
                    'ttl' => $ttl,
                    'changetype' => "REPLACE",
                    'records' => [
                        [
                            'content' => $content,
                            'disabled' => false
                        ]
                    ]
                ]
            ]
        ];
        return $this->apiclient->patch('api/v1/servers/localhost/zones/' . Helper::canonical($zone), $param);
    }
    /*
        Delete a single  Zones from given Server

        @return a no content
    */
    public function deleteRecord($zone, $name, $type)
    {
        $param = [
            'rrsets' => [
                [
                    'name' => $name . '.',
                    'type' => $type,
                    'changetype' => "DELETE",

                ]
            ]
        ];


        return $this->apiclient->patch('api/v1/servers/localhost/zones/' . Helper::canonical($zone));
    }
}
