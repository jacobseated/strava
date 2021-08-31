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


class admin extends abstract_app_base {


    public function main()
    {
        $css_code = file_get_contents('dk_static.css');
        $html = '<!doctype html>
        <html>
        <head>
          <title>Strava Test App</title>
          <style>* {margin:0;padding:0;} p {padding:0 0 1rem 0;}' . $css_code . ' body {font-size:1.2rem;} #page_wrap {margin: 3rem auto;max-width:1024px;min-width:300px;width:100%;}</style>
        </head>
        <body>
          <div id="page_wrap">
            <div class="dk_note"><p>Strava test Application. Authorize this app below.</div>
            <a href="/authorize" class="dk_button">Authorize</a>
          </div>
        </body>
        </html>';
        respond(200, $html);
    }

}