<?php

class Response
{
    public $code = 99;
    public $msg = '';

    public function showJsonData()
    {
        echo json_encode($this);
    }
}

$response = new Response;

?>