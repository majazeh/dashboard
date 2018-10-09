<?php
namespace Majazeh\Dashboard;

use Exception;

class MajazehJsonException extends Exception
{
    public $json_response;
    public function __construct($response)
    {
    	$this->code = $response->getStatusCode();
    	$this->message = $response->getData()->message;
        $this->json_response = $response;
        parent::__construct();
    }
}
?>