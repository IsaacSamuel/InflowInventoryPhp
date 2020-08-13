<?php
declare(strict_types=1);
require __DIR__ . "/../vendor/autoload.php";

use InflowAPI\InflowEndpoints;
use PHPUnit\Framework\TestCase;

final class inflowEndpointsTest extends TestCase {
    public function getCurrAPIVersion() {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
        $dotenv->load();
        $api_version = (getenv("API_VERSION") ? $_ENV["API_VERSION"] : '2020-08-06');

        return $api_version;
    }

    public function testObjectCannotBeCreatedWithNullCompanyID() {
        $this->expectException(TypeError::class);
        
        $inflow_endpoints = new InflowEndpoints(null);
    }
    public function testObjectCannotBeCreatedWithOmittedVersionID() {
        $this->expectException(TypeError::class);
        
        $inflow_endpoints = new InflowEndpoints('00000-0000000-000000');
    }
    public function testObjectCanBeCreatedWithValidParameters() {        
        $inflow_endpoints = new InflowEndpoints('00000-0000000-000000', '2022-08-02');
        
        $this->assertInstanceOf(
            InflowEndpoints::class,
            $inflow_endpoints
        );
    }
    public function testCategoriesEndpointReturnsCorrectlyForCurrVersion() {      
        $api_version = $this->getCurrAPIVersion();  
        $inflow_endpoints = new InflowEndpoints('00000-0000000-000000', $api_version);
        $category_endpoint = $inflow_endpoints->getEndpoint('categories');
        
        $this->assertEquals(
            $category_endpoint,
            "https://cloudapi.inflowinventory.com/00000-0000000-000000/categories"
        );
    }
    public function testCategoriesEndpointThrowsExceptionForInvalidAPIVersion() {      
        $api_version = $this->getCurrAPIVersion();  
        $inflow_endpoints = new InflowEndpoints('00000-0000000-000000', '2200/20/20');
        $category_endpoint = $inflow_endpoints->getEndpoint('categories');

        $this->assertFalse($category_endpoint);
    }
}
?>