<?php
/**
 * File Description: CONFIGURATION FILE TO BOOTSTRAP UNIT TESTING
 *
 * @category
 * @package
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */

// SET THIS TO WHATEVER YOUR  URL TO GET TO THE
// `tests` DIRECTORY IS, ON THE DEVELOPMENT MACHINE
// NO TRAILING SLASH  (FOR LDAP TESTING)
if ( ! defined('TEST_DIRECTORY')) {
    define('TEST_DIRECTORY', 'http://localhost:8888/flightMvc/tests');
}
