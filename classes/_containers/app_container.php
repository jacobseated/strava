<?php

/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */

namespace new_dk\_containers;

use \Exception;

use \new_dk\_containers\abstract_global_container;


/**
 * Container object for individual _app's — you can place your own dependencies in this container
 * @package new_dk\_containers
 */
class app_container extends abstract_global_container
{

    private $strava_secret;
    private $strava_id;


    /**
     * Sets or returns the strava client id
     * @param int|null $id 
     * @return $this|string 
     * @throws Exception 
     */
    public function strava_id(int $id = null)
    {
        if ($id !== null) {
            if (!empty($this->strava_id)) {
                throw new Exception("Secret already set.");
            } else {
                $this->strava_id = $id;
                return $this;
            }
        }
        return $this->strava_secret;
    }

    /**
     * Sets or returns the strava client secret
     * @param string|null $secret 
     * @return $this|string 
     * @throws Exception 
     */
    public function strava_secret(string $secret = null)
    {
        if ($secret !== null) {
            if (!empty($this->strava_secret)) {
                throw new Exception("Secret already set.");
            } else {
                $this->strava_secret = $secret;
                return $this;
            }
        }
        return $this->strava_secret;
    }
}
