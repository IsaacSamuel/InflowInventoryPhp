<?php
declare(strict_types=1);

namespace InflowAPI;

require __DIR__ . "/../vendor/autoload.php";
use Httpful\Request;
use InflowAPI\InflowEndpoints;

class InflowAPI {
    protected $secret_key;
    protected $api_version;
    protected $endpoints;

    public function __construct(string $secret_key, string $company_id, string $api_version = '2020-08-06') {
        $this->endpoints = new InflowEndpoints($company_id, $api_version);

        $this->secret_key = $secret_key;
        $this->api_version = $api_version;
    }

    // Initializes our request object with headers required by API (including secret API key)
    protected function init_api_request() {
        $template = Request::init();
        $template->addHeaders(array(
            'Authorization' => 'Bearer ' . $this->secret_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json;version=' . $this->api_version
        ));
        return $template;
    }
}

?>