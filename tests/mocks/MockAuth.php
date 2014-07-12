<?php
/**
 * File Description:
 *
 * @category
 * @package
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
namespace core\auth;
class Auth {
    public function __construct($db)
    {

    }

    public function checkPersistentLogin($token, $id)
    {
        if($token == '123' and $id == '456') {
            return 1;
        } else{
            return false;
        }
    }

    public function createPersistentLogin($arg, $arg2)
    {
        if ($arg2 == 'ap2') {
            return 1;
        } else {
            return 0;
        }
    }

    public function ldapAuthCheck($ldap, $name, $pass)
    {
        if ($name == 'ap2' and $pass == 'test')
        {
            return true;
        } else {
            return 0;
        }
    }
}
