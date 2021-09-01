<?php

/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */

namespace new_dk\_app\strava;

use \new_dk\_app\abstract_app_base;


class admin extends abstract_app_base
{


  public function main()
  {
    if (!is_user_logged_in()) {
      // If the user is not logged in to Wordpress, redirect to the login page
      header('location: ' . $this->gc->base_url() . 'login', true, 303);
      exit();
    }
    $template = require_once 'tpl/d/admin.php';
    respond(200, $template);
  }
}
