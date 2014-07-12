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
class User
{
    public function __construct($dep)
    {

    }

    public function getUserInfo($arr)
    {
        return array ('id' => 1, 'username' => 'Andrew Podner');
    }
}
