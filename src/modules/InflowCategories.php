<?php 
declare(strict_types=1);

namespace InflowAPI\Modules;

require __DIR__ . "/../../vendor/autoload.php";
use InflowAPI\InflowAPI;
use Httpful\Request;

class InflowCategories extends InflowAPI {

    public function getListCategories(array $request_params = array()) {
        $template = $this->init_api_request();
        Request::ini($template);

        $url = $this->endpoints->getEndpoint("categories");

        $retval = Request::get($url)->send();

        return $retval;
    }

}


