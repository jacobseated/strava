<?php

/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */

namespace new_dk\_containers;

use \doorkeeper\lib\db_client\mysqli_client;
use \new_dk\http_client\dk_http_client;
use \new_dk\dev\dev_log;
use \new_dk\http_client\http_response;


/**
 * Globally available properties and objects
 * @package new_dk\_containers
 */
abstract class abstract_global_container
{
    private $base_path;
    private $requested_path;

    private $db;
    private $http;
    private $dev_log;


    public function __construct($base_path, mysqli_client $db, dk_http_client $http, dev_log $dev_log, )
    {
        $this->base_path = $base_path;
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $this->requested_path = $parsed_url['path'];

        $this->db = $db;
        $this->http = $http;
        $this->dev_log = $dev_log;
    }

    /**
     * Returns the absolute server-sided base path of the CMS E.g.: /var/www/
     * @return string
     */
    public function base_path()
    {
            return $this->base_path;
    }

    /**
     * Returns the requested path as defined in REQUEST_URI
     * @return string 
     */
    public function requested_path()
    {
        return $this->requested_path;
    }

    /**
     * Returns the database object
     * @return mysqli_client 
     */
    public function db() {
        return $this->db;
    }
    /**
     * Returns the HTTP client
     * @return dk_http_client 
     */
    public function http() {
        return $this->http;
    }
    /**
     * Returns the dev_log
     * @return dev_log 
     */
    public function dev_log() {
        return $this->dev_log;
    }
}
