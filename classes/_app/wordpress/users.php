<?php

/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */


namespace new_dk\_app\wordpress;

use Exception;
use \new_dk\_app\abstract_app_base;
use \new_dk\_containers\app_container;

class users extends abstract_app_base
{

    protected app_container $gc;

    public function main()
    {
        // If the /authorize url was requested (via button/link on /admin)
        if ($this->gc->requested_path() === '/login') {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!is_user_logged_in()) {
                    $this->show_login_form();
                }
                $html_for_tpl = '<p>You are already logged in. Do you want to log out?</p><a href="/logout" class="dk_button">Logout</a>';
                $html_template = $template = require_once 'tpl/d/default.php';
                respond(200, $html_template);
            }
            $this->login();
        } elseif ($this->gc->requested_path() === '/logout') {
            $this->logout();
        } else {
            respond(404, 'Resource not found.');
        }
    }

    /**
     * Function to authenticate with Wordpress
     * @return void 
     */
    private function login()
    {

        if ((empty($_POST['username'])) || (empty($_POST['password']))) {
            respond(400, 'Bad request. Please enter both a username and a password.');
        }

        if (!validate_username($_POST['username'])) {
            respond(400, 'Bad request. Invalid username.');
        }

        // $user_result = wp_authenticate($_POST['username'], $_POST['password']);

        // First get the user details
        $user = get_user_by('login', $_POST['username']);

        // If no error received, set the WP Cookie
        if (is_wp_error($user)) {
            respond(400, 'Failed to login!');
        }

        wp_set_current_user($user->ID); // Set the current user detail
        wp_set_auth_cookie($user->ID);

        respond(200, 'Successfully logged in!');
    }

    private function show_login_form()
    {
        $template = require_once 'tpl/d/login.php';

        respond(200, $template);
    }

    private function logout()
    {
        if (!is_user_logged_in()) {
            respond(400, 'Error: You do not seem to be logged in.');
        }
        wp_clear_auth_cookie();

        respond(200, 'You are now logged out.');
    }
}
