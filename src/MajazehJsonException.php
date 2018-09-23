<?php
namespace Majazeh\Dashboard;

use Exception;

class MajazehJsonException extends Exception
{
    public $json_response;
    public function __construct($response)
    {
        $this->json_response = $response;
        parent::__construct();
    }
}
?>