<?php
declare(strict_types=1);
require __DIR__ . "/../vendor/autoload.php";

use InflowAPI\InflowAPI;
use PHPUnit\Framework\TestCase;

final class inflowApiTest extends TestCase {

    public function testObjectCanBeCreatedWithInvalidNullKeys() {
        $this->expectException(TypeError::class);
        
        $inflow_api = new InflowAPI(null, null);
    }

    public function testObjectCanBeCreatedWithValidKeys() {
        //Load secret keys from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $secret_key = $_ENV["SECRET_API_KEY"];
        $company_id = $_ENV["COMPANY_ID"];

        $inflow_api = new InflowAPI($secret_key, $company_id);
        
        $this->assertInstanceOf(
            InflowAPI::class,
            $inflow_api
        );
    }
}
 
?>