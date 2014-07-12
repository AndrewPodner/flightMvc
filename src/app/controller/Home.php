<?php
/**
 * File Description: Home controller for main page, login and logout, etc
 *
 * @category   controller
 * @package    invy
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
namespace app\controller;
class Home extends \core\lib\Controller
{
    /**
     * Constructor: Dependencies are picked up from routes.php  The default
     * Dependencies sent to the controller are Config and Input, which are then
     * passed through to the parent constructor
     * @param array $deps dependencies
     * @param array $params parameters passed via the uri
     */
    public function __construct($deps, $params)
    {
        parent::__construct($deps, $params);
    }

    /**
     * Main Menu, Home Page
     */
    public function index()
    {
        echo 'Ok it is working!';
    }

    public function info()
    {
        echo phpinfo();
    }

    public function server()
    {
        debug($this->input);
    }

    public function env() {
        debug($_SERVER);
        debug($_ENV);
    }


}
