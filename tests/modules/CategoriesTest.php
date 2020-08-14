<?php
declare(strict_types=1);
require __DIR__ . "/../../vendor/autoload.php";

use InflowAPI\Modules\InflowCategories;
use PHPUnit\Framework\TestCase;

final class CategoriesTest extends TestCase {
    private function getInflowAPIObject() {
        //Load secret keys from .env file
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
        $dotenv->load();
        $secret_key = getenv("SECRET_API_KEY");
        $company_id = getenv("COMPANY_ID");
        $api_version = getenv("API_VERSION");

        //Api version is optional
        if($api_version) {
            $inflow_api = new InflowCategories($secret_key, $company_id, $api_version);
        }
        else {
            $inflow_api = new InflowCategories($secret_key, $company_id);
        }
        return $inflow_api;
    }

    public function testListCategories() {
        $category_api = $this->getInflowAPIObject();
        $response = $category_api->getListCategories();

        $this->assertEquals($response->meta_data["http_code"], 200);
    }

}