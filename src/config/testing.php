<?php
/**
 * File Description: Configuration file for development environment
 *
 * @category   config
 * @package    sigma
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */

// DEFAULT SITE TITLE
$config['default_title'] = "APP Title Here";

// DATABASE CREDENTIALS
$config['db_default']['dsn'] = '';
$config['db_default']['db_user'] = '';
$config['db_default']['db_password'] = '';
$config['db_default']['driver'] = '';

// DATABASE SETTINGS
$config['db_prefix'] = "";

// PATH FOR ERROR LOG
$config['error_log_path'] = 'error_log/';

// Enable or Disable Authentication
$config['enable_auth'] = false;

// Views Directory
\Flight::set('flight.views.path', 'src/app/view');

// LDAP API Configuration
$config['ldap_key'] = '';
$config['ldap_api_url'] = "";

// Auth Module Salt Phrase
$config['auth_salt_phrase'] = '';
