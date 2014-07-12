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
require_once '../src/core/lib/Controller.php';
require_once '../src/core/lib/Input.php';

use core\lib\Input;

if (! session_id()) {
    session_start();
}

class ControllerTest extends PHPUnit_Framework_TestCase

{
public $input;

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testConstructorDocRoot()
    {
        $stub = $this->getMockBuilder('config')
                     ->getMock();
        $input = new \core\lib\Input(array('config'=>$stub));
        $arrParams = array('param1', 'param2');
        $ctrl = new \core\lib\Controller(array('config' => $stub, 'input' => $input), $arrParams);
    }

    public function testConstructorHttpHost()
    {
        $stub = $this->getMockBuilder('config')
            ->getMock();
        $input = new \core\lib\Input(array('config'=>$stub));
        $input->server['HTTP_HOST'] = 'example.com';
        $arrParams = array('param1', 'param2');
        $ctrl = new \core\lib\Controller(array('config' => $stub, 'input' => $input), $arrParams);
    }

    /**
     * @expectedException \Exception
     */
    public function testConstructorNull()
    {
        $fail = new \core\lib\Controller();
    }



}