<?php

/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */

define('WP_USE_THEMES', false); // Do not load WP template, since we use our own template-system.
require 'wordpress/wp-load.php'; // Make Wordpress functions available


// get_user_meta();

// echo get_current_user_id();exit();


if (is_user_logged_in()) {
    echo 'You are currently logged in.';exit();
} else {
    echo 'You are currently not logged in.';exit();
}