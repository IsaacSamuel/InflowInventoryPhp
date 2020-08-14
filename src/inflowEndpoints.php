<?php
declare(strict_types=1);

namespace InflowAPI;

require __DIR__ . "/../vendor/autoload.php";

class InflowEndpoints {
    private $api_version;
    private $companyID;
    private $endpoints;

    public function setAPIVersion(string $api_version) {
        $this->api_version = $api_version;
    }

    // Can eventually load endpoints from e.g. a JSON file
    private function loadEndpoints() {
        $this->endpoints = array(
            '2020-08-06' => array(
                'base_api_endpoint' => 'https://cloudapi.inflowinventory.com/',
                'categories' => $this->companyID . '/categories/'
            )
        );
    }

    public function __construct(string $companyID, string $api_version) {
        $this->companyID = $companyID;
        $this->loadEndpoints();
        $this->setAPIVersion($api_version);
    }

    public function getEndpoint(string $moduleName) {
        if (isset($this->endpoints[$this->api_version])) {
            return $this->endpoints[$this->api_version]['base_api_endpoint'] 
                . $this->endpoints[$this->api_version][$moduleName];
        }
        return false;
    }
}

?>