<?php
declare(strict_types=1);

namespace InflowAPI;

final class InflowAPI {
    private $secret_key;
    private $company_id;

    public function __construct(string $secret_key, string $company_id) {
        $this->secret_key = $secret_key;
        $this->company_id = $company_id;
    }
}

?>