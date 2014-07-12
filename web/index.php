<?php
/**
 * File Description: Application front controller
 *
 * @category   main
 * @package    sigma
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */

// Define the running mode if desired
// If set to null, the auto-detector will take over
// Valid values are `development`, `testing`, `production`
define('APP_ENVIRONMENT',  null);

// include core files
require_once dirname(__DIR__) . '/libraries/autoload.php';

// include global functions
require_once dirname(__DIR__) . '/src/core/functions/global_functions.php';

// Load the environment based configuration
require_once dirname(__DIR__) . '/src/config/' .setEnvironment(APP_ENVIRONMENT). '.php';

// load the bootstrap file
require_once dirname(__DIR__) . '/src/core/bootstrap.php';

// here we go!
Flight::start();