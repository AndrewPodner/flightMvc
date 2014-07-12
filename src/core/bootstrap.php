<?php
/**
 * File Description: Application Bootstrap
 *
 * @category   none
 * @package    sigma
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
// Initialize a PHP Session
session_start();

// Initialize the Configuration Dependency
Flight::register('config', '\core\lib\Config', array($config));

// Put the Running Mode into a Config Variable
Flight::config()->set('environment', setEnvironment(APP_ENVIRONMENT));

// Load the Superglobals into an accessible container
Flight::register('input', '\core\lib\Input', array());

// Load the Logger Dependency
Flight::register('log', '\core\helper\Logger', array(array('config' => Flight::config())));

// Establish the default database connection
Flight::register('db', '\core\data\PdoConn', array(array('config' => Flight::config())));

// Initialize Application Routing
require_once 'routes.php';

