<?php
/**
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-2021_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 *  /_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
 * 
 *  @author JacobSeated <seat@beamtic.com>
 */


opcache_invalidate(__FILE__, true);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Define BASE_PATH for use with file-handling and includes
define('BASE_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', __DIR__), '/') . '/');


// New DK
require_once '../.credentials/strava_credentials.php';
require_once '../.credentials/db_credentials.php';
require_once 'includes/global_functions.php'; // Technically, global functions should not be relied on, but this is just for testing purposes.
require_once 'classes/dev_log.php';
require_once 'classes/http/http.php';
require_once 'classes/http/http_response.php';
require_once 'classes/router/router.php';
require_once 'classes/router/types/route.php';
require_once 'classes/_app/abstract_app_base.php';
require_once 'classes/_containers/abstract_global_container.php';
require_once 'classes/_containers/app_container.php';

// Doorkeeper external dependencies
// Note. We should rely on Wordpress build-in Database tools — these are only used for testing purposes doing development
require_once '/var/www/beamtic/lib/class_traits/no_set.php';
require_once '/var/www/beamtic/lib/db_client/dk_credentials.php';
require_once '/var/www/beamtic/lib/db_client/db_client_interface.php';
require_once '/var/www/beamtic/lib/db_client/mysqli_client.php';

use new_dk\dev\dev_log;
use new_dk\http_client\dk_http_client;
use new_dk\router\router;
use new_dk\router\types\route;
use doorkeeper\lib\db_client\dk_credentials;
use doorkeeper\lib\db_client\mysqli_client;

use new_dk\_containers\app_container;

$dev_log = new dev_log();
$http = new dk_http_client($dev_log);
$db_client = new mysqli_client(new dk_credentials('localhost', $db_user, $db_password, 'dk_strava'));
$db_client->connect();

$gc = new app_container(BASE_PATH, $db_client, $http, $dev_log); // Global Container
$gc->strava_id($strava_client_id)->strava_secret($strava_client_secret);

// dev_log::write($response->headers());exit();

$routes = [
    (new route(['GET', 'POST']))->string('/authorize')->class_handler('strava/authorize'),
    (new route(['GET', 'POST']))->string('/deauthorize')->class_handler('strava/authorize'),
    (new route(['GET', 'POST']))->string('/')->class_handler('strava/authorize'),
    (new route(['GET']))->string('/admin')->class_handler('strava/admin'),
    (new route(['GET', 'POST']))->string('/phpinfo')->function_handler('phpinfo')
];

function hallo_world() {
  echo 'Hallo World!';
  exit();
}

$router = new router(BASE_PATH, $routes, $http, $dev_log, $db_client, $gc);

// If the route was not recognized by the router
respond(404, '<h1>404 Not Found</h1><p>Page not recognized...</p>');