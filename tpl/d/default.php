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
          <div id="page_wrap" class="dk_cbox">
          '.$html_for_tpl.'
          </div>
        </body>
        </html>';


return $_load_template;