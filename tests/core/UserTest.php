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
require_once '../src/core/auth/User.php';

class UserTest extends PHPUnit_Framework_TestCase
{
    public $db;
    public $user;

    public function setUp()
    {

    }

    public function tearDown()
    {

    }


    public function testConstructor()
    {
        $db = $this->getMockBuilder('db')
            ->setMethods(array('update'))
            ->getMock();
        $this->user = new \core\auth\User(array('db' => $db));
    }

    /**
     * @expectedException \Exception
     */
    public function testConstructorNull()
    {
       $fail = new \core\auth\User();
    }

    public function testGetUserInfo()
    {


        $stub = $this->getMockBuilder('db')
            ->setMethods(array('getUserRightsById'))
            ->getMock();

        $stub->expects($this->any())
                 ->method('getUserRightsById')
                 ->will($this->returnValue('1'));

        $array = array('id' => '1');
        $expected = 1;
        $user = new \core\auth\User(array('db' => $stub));
        $returned = $user->getUserInfo($array);

        $this->assertEquals(
            $expected,
            $returned,
            'Get User Info Test Failed'
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testGetUserInfoFail()
    {


        $stub = $this->getMockBuilder('db')
            ->setMethods(array('getUserRightsById'))
            ->getMock();

        $stub->expects($this->any())
            ->method('getUserRightsById')
            ->will($this->returnValue(array()));

        $array = array('id' => '1');
        $expected = 1;
        $user = new \core\auth\User(array('db' => $stub));
        $returned = $user->getUserInfo($array);

        $this->assertEquals(
            $expected,
            $returned,
            'Get User Info Test Fail did not throw exception'
        );
    }

    public function testUpdatePersistentLogin()
    {
        $stub = $this->getMockBuilder('db')
            ->setMethods(array('update'))
            ->getMock();

        $stub->expects($this->any())
            ->method('update')
            ->will($this->returnValue(1));

        $uid = '1';
        $uniqueId = 'abc123';
        $token = 'def456';
        $expected = 1;
        $user = new \core\auth\User(array('db' => $stub));
        $returned = $user->updateUserPersistentLogin($uid, $uniqueId, $token);

        $this->assertEquals(
            $expected,
            $returned,
            'Update Persistent Login failed'
        );
    }


    public function testUpdatePersistentLoginFail()
    {
        $stub = $this->getMockBuilder('db')
            ->setMethods(array('update'))
            ->getMock();

        $stub->expects($this->any())
            ->method('update')
            ->will($this->returnValue(false));

        $uid = 'X';
        $uniqueId = 'abc123';
        $token = 'def456';
        $user = new \core\auth\User(array('db' => $stub));
        $this->assertFalse($user->updateUserPersistentLogin($uid, $uniqueId, $token));

    }

}
