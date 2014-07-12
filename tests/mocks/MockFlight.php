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
class Flight
{
    public static function input($persist)
    {
        return new InputMock($persist);
    }

    public static function redirect($location)
    {
        return true;
    }

    public function config()
    {
        return true;
    }

    public static function db()
    {
        return true;
    }
}


class InputMock
{
    public $server;
    public $cookie;
    public $post;

    public function __construct($persist)
    {
        $this->server = array('HTTP_HOST', 'pimsfilght.dev');
        if ($persist == 1) {
            $this->cookie = array('pimsId' => '456', 'pimsToken' => '123');
        } else {
            $this->cookie = array();
        }

        if ($persist == 2) {
            $this->post = array('sub' => 'login');
        }

        if ($persist == 3) {
            $this->post = array('sub' => 'login', 'uid' => 'ap2', 'pass' => 'test');
        }

        if ($persist == 4) {
            $this->post = array('sub' => 'login', 'uid' => 'ap2', 'pass' => 'test2');
        }

    }

    public function session()
    {
        return false;
    }
}


