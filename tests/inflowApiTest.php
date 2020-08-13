<?php
declare(strict_types=1);
require __DIR__ . "/../vendor/autoload.php";

use InflowAPI\InflowAPI;
use PHPUnit\Framework\TestCase;

final class inflowApiTest extends TestCase {
    // Utility functions
    // Utility function for calling a private method
    public function invokeMethod(&$object, $methodName, array $parameters = array()) {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    //Utility function for returning a inflow api object using secret keys from .env file
    public function getInflowAPIObject() {
        //Load secret keys from .env file
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
        $dotenv->load();
        $secret_key = getenv("SECRET_API_KEY");
        $company_id = getenv("COMPANY_ID");
        $api_version = getenv("API_VERSION");

        //Api version is optional
        if($api_version) {
            $inflow_api = new InflowAPI($secret_key, $company_id, $api_version);
        }
        else {
            $inflow_api = new InflowAPI($secret_key, $company_id);
        }
        return $inflow_api;
    }

    //TESTS
    public function testObjectCannotBeCreatedWithNullKeys() {
        $this->expectException(TypeError::class);
        
        $inflow_api = new InflowAPI(null, null);
    }

    public function testObjectCanBeCreatedWithValidKeys() {
        $inflow_api = $this->getInflowAPIObject();
        
        $this->assertInstanceOf(
            InflowAPI::class,
            $inflow_api
        );
    }

    public function testHeadersAreSetCorrectly() {
        //Load secret keys from .env file
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
        $dotenv->load();
        $secret_key = getenv("SECRET_API_KEY");
        $api_version = (getenv("API_VERSION") ? $_ENV["API_VERSION"] : '2020-08-06');
        
        $inflow_api = $this->getInflowAPIObject();

        $request = $this->invokeMethod($inflow_api, 'init_api_request', array());

        $this->assertEquals(
            $request->headers,
            array(
                'Authorization' => 'Bearer ' . $secret_key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json;version=' . $api_version 
            )
        );
    }
}
 
?>