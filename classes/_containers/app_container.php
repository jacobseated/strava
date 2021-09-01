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

    protected function main()
    {
        // Check for dependency
        if (!$this->check_for_included_file('wp-load.php')) {
            respond(500, 'Required <b>wp-load.php</b> file not included.');
        }
    }


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

    /**
     * Since this app depends on Global Wordpress features, we check if the relevant file was included
     * @return bool 
     */
    private function check_for_included_file(string $file_name)
    {
        $list_of_fules_arr = get_included_files();
        foreach ($list_of_fules_arr as $file_path) {
            if (false !== strpos($file_path, $file_name)) {
                return true;
            }
        }
        return false;
    }
}
