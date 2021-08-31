<?php

namespace new_dk\http_client;

class http_response
{

    function __construct($response_data = '', $http_response_header = [])
    {
        $status_str = array_shift($http_response_header);
        $this->protocol = strtok($status_str, ' ');
        $this->status_message = strtok(strtok($status_str, ' '));
        $this->status_code = strtok($this->status_message, ' ');
        foreach ($http_response_header as $value) {
            $name = strstr($value, ':', true);   
            $this->headers["$name"] = trim(substr(strstr($value, ':'), 1));
        }
        $this->data = $response_data;
    }

    public function status_code()
    {
        return $this->status_code;
    }

    public function status_message()
    {
        return $this->status_message;
    }

    public function data()
    {
        return $this->data;
    }

    public function headers()
    {
        return $this->headers;
    }

    public function protocol()
    {
        return $this->protocol;
    }

    private $protocol;
    private $status_code;
    private $status_message;
    private $headers;
    private $data;
}
