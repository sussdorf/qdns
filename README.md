## Thank you for using dnic/qdns for your Powerdns Project
This is a very simple SDK, please keep in mind that this SDK has only the most necessary functions to work successfully with the api of Powerdns.
It works with all types supported by Powerdns.
If you have any questions, feel free to contact me 

Install in your Project:
```
composer require dnic/qdns
```
### Use the Libary:
 
**List all Zones**
```
<?php
require_once 'vendor/autoload.php';
use Qdns\ApiClient;

$client = new ApiClient('your_powerdns_apikey','your_powerdnsurl_with_port');
echo $client->zone()->listZones();
```


**List a single Zone**
```
<?php
require_once 'vendor/autoload.php';
use Qdns\ApiClient;

$client = new ApiClient('your_powerdns_apikey','your_powerdnsurl_with_port');
echo $client->zone()->listZone('example.com');
```
**Add Record to Zone**
```
<?php
require_once 'vendor/autoload.php';
use Qdns\ApiClient;

$client = new ApiClient('your_powerdns_apikey','your_powerdnsurl_with_port');
echo $client->record()->addRecord('example.com', 'test.example.com', 'A', 60,'192.168.178.9');
```
**Delete Record from Zone**
```
<?php
require_once 'vendor/autoload.php';
use Qdns\ApiClient;

$client = new ApiClient('your_powerdns_apikey','your_powerdnsurl_with_port');
echo $client->record()->deleteRecord('example.com', 'test.example.com', 'A');
```
