<?php

/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */

namespace new_dk\_app\strava;

use Exception;
use \new_dk\_app\abstract_app_base;

use \new_dk\_containers\app_container;


class authorize extends abstract_app_base
{

    protected app_container $gc;

    public function main()
    {
        // If the /authorize url was requested (via button/link on /admin)
        if ($this->gc->requested_path() === '/authorize') {
            $this->authorize();
        } elseif ($this->gc->requested_path() === '/deauthorize') {
            $this->deauthorize();
        } else {
            $this->token_exchange();
        }
    }


    /**
     * Redirect the user to authorize with Strava
     * @return never 
     */
    public function authorize()
    {
        $redirect_uri = 'http://test.beamtic.beta/';
        $query_string = '?client_id=68988&response_type=code&redirect_uri=' . $redirect_uri . '&approval_prompt=force';
        header('Location: https://www.strava.com/api/v3/oauth/authorize' . $query_string, 301);
        exit();
    }

    /**
     * Deauthorize the app from a users Strava account
     * @return void 
     * @throws Exception 
     */
    public function deauthorize() {

        $wp_user_id = '';

        $result = $this->db->prepared_query(
            'SELECT * FROM strava_auth WHERE wp_user_id = ?',
            [$wp_user_id]
        );

        if (false === $result) {
            respond(500, 'Unable to fetch auth tokens from the database at thise time.');
        }

        $this->res = $this->http->post('https://www.strava.com/oauth/deauthorize', ['access_token' => $result->access_token]);

        // Make sure the API responeded properly, if not we show an error
        if ($this->res->status_code() !== '200') {
            respond(200, 'Strava responded with: ' . $this->res->status_code() . ' — something appears not to be working.');
        }

        respond(200, 'Successfully deauthorized.');

    }


    /**
     * Optain new token from Strava
     * @return void 
     */
    public function token_exchange()
    {
        if (empty($_GET["code"])) {
            respond(400, '400 Bad Request: Missing one or more required URL parameters.');
        }
        $usr_code = $_GET["code"];

        $client_id = $this->gc->strava_id();
        $client_secret = $this->gc->strava_secret();


        $this->dev_log->write([
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $usr_code,
            'grant_type' => 'authorization_code'
        ]);


        $this->res = $this->http->post('https://www.strava.com/oauth/token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $usr_code,
            'grant_type' => 'authorization_code'
        ]);

        $jsonObj = json_decode($this->res->data());

        $this->dev_log->write($this->res);

        // Make sure the API responeded properly, if not we show an error
        if ($this->res->status_code() !== '200') {
            respond(200, 'Strava responded with: ' . $this->res->status_code() . ' — something appears not to be working.');
        }

        $result = $this->db->prepared_query(
            'INSERT INTO strava_auth (athlete_id, token_type, expires_at, expires_in, refresh_token, access_token) VALUES (?,?,?,?,?,?)',
            [$jsonObj->athlete->id, $jsonObj->token_type, $jsonObj->expires_at, $jsonObj->expires_in, $jsonObj->refresh_token, $jsonObj->access_token]
        );

        if (false === $result) {
            echo 'Failed to insert new row in Database table.';
            exit();
        }

        if ($this->db->is_duplicate_key($result)) {
            $result = $this->db->prepared_query(
                'UPDATE strava_auth SET expires_at = ?, expires_in = ?, refresh_token = ?, access_token = ?',
                [$jsonObj->expires_at, $jsonObj->expires_in, $jsonObj->refresh_token, $jsonObj->access_token]
            );
            if (false === $result) {
                echo 'Failed to update row in Database table.';
                exit();
            }
        }

        // If everything seems Ok
        respond(200, $this->res->status_code() . ': Ok');
    }
}
