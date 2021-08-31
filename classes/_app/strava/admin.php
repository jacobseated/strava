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
          <style>* {margin:0;padding:0;} h1,h2,h3,h4,p {padding:0 0 1rem 0;}' . $css_code . ' body {font-size:1.2rem;} #page_wrap {margin: 3rem auto;max-width:1024px;min-width:300px;width:100%;}</style>
        </head>
        <body>
          <div id="page_wrap">
            <h1>Update or refresh your Access tokens.</h1>
            
              <p>Pushing the <b class="dk_ie">Authorize</b> button below will grant us an access token for use with this account; you are normally asked to do this only when needed, so there is rarely a reason to do it manually.</p>
              <p>Access tokens automatically expire after a while.</p>
            
            <div class="dk_cbox">
              <h2 class="dk_st" style="font-size:1.2rem;">Access tokens:</h2>
              <div>
              <a href="/authorize" class="dk_button dk_mar" style="margin-bottom:1.5rem;">Authorize</a>
              <a href="/deauthorize" class="dk_button dk_mar" style="margin-bottom:1.5rem;">Revoke all</a>
              </div>
            </div>
            <h1>Other</h1>
            <p>Nothing more to configure yet..</p>
          </div>
        </body>
        </html>';
        respond(200, $html);
    }

}