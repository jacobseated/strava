<?php
/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */


$css_code = file_get_contents('tpl/d/dk_static.css') . file_get_contents('tpl/d/essential.css');

$_load_template = '
<!doctype html>
        <html>
        <head>
          <title>Strava Test App</title>
          <style>' . $css_code . '</style>
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


return $_load_template;