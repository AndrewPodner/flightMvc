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
require_once '../src/core/auth/Auth.php';
require_once '../src/core/helper/Filter.php';
require_once 'mocks/MockPdo.php';


class AuthTest extends PHPUnit_Framework_TestCase
{

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
        $auth = new \core\auth\Auth(array('db' => $db));
    }

    /**
     * @expectedException \Exception
     */
    public function testConstructorNull()
    {
        $fail = new \core\auth\Auth();
    }

    /**
     * @expectedException \Exception
     */
    public function testCheckPersistentLoginFailFilter()
    {
        $pdoMock = new MockPDO();
        $auth = new \core\auth\Auth(array('db' => $pdoMock));

        $token = 'abc123$%';
        $uniqueId = 'def456';

        $auth->checkPersistentLogin($token, $uniqueId);

    }

    public function testCheckPersistentLoginSuccess()
    {
        $pdoMock = new MockPDO();
        $auth = new \core\auth\Auth(array('db' => $pdoMock));

        $token = 'abc123';
        $uniqueId = 'def456';

        $return = $auth->checkPersistentLogin($token, $uniqueId);

    }

    /**
     * @runInSeparateProcess
     */
    public function testCreatePersistentLoginSuccess()
    {
        $uid = 'abc';
        $salt = 'def';

        $stub = $this->getMockBuilder('db')
            ->setMethods(array('updateUserRightsById'))
            ->getMock();

        $stub->expects($this->any())
            ->method('updateUserRightsById')
            ->will($this->returnValue('1'));

        $expected = 1;


        $auth = new \core\auth\Auth(array('db' => $stub));
        $return = $auth->createPersistentLogin($uid, $salt);

        $this->assertEquals(
            $expected,
            $return,
            'Create Persistent Login Failed'
        );

    }

    /**
     * @expectedException \Exception
     * @runInSeparateProcess
     */
    public function testLdapAuthCheckFailFilter(){
        $db = $this->getMockBuilder('db')
                   ->getMock();

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->getMock();

        $domain_logon = 'testLogin$#';
        $pass = 'testPass';

        $auth = new \core\auth\Auth(array('db' => $db));
        $return = $auth->ldapAuthCheck($ldap, $domain_logon, $pass);

    }


    /**
     *
     * @runInSeparateProcess
     */
    public function testLdapAuthCheck(){
        $db = $this->getMockBuilder('db')
            ->getMock();

        $ldap = $this->getMockBuilder('core\auth\Ldap')
                     ->disableOriginalConstructor()
                     ->setMethods(array('requestLdapVerification'))
                     ->getMock();

        $ldap->expects($this->once())
             ->method('requestLdapVerification')
             ->will($this->returnValue('Test,User,test@user.com,tu'));

        $domain_logon = 'testLogin';
        $pass = 'testPass';

        $expected = 'TU';

        $auth = new \core\auth\Auth(array('db' => $db));
        $return = $auth->ldapAuthCheck($ldap, $domain_logon, $pass);

        $this->assertEquals($expected, $return['logon']);
    }

    /**
     *
     * @runInSeparateProcess
     */
    public function testLdapAuthCheckFail(){
        $db = $this->getMockBuilder('db')
            ->getMock();

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        $ldap->expects($this->once())
            ->method('requestLdapVerification')
            ->will($this->returnValue('X,X,X,X'));

        $domain_logon = 'testLogin';
        $pass = 'testPass';

        $expected = '0';

        $auth = new \core\auth\Auth(array('db' => $db));
        $return = $auth->ldapAuthCheck($ldap, $domain_logon, $pass);

        $this->assertEquals($expected, $return);
    }

    /**
     * @expectedException \Exception
     * @runInSeparateProcess
     */
    public function testLdapAuthCheckFailBadUsername(){
        $db = $this->getMockBuilder('db')
            ->getMock();

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        /*
        $ldap->expects($this->once())
            ->method('requestLdapVerification')
            ->will($this->returnValue('X,X,X,X'));
        */
        $domain_logon = 'testLogin#$';
        $pass = 'testPass';

        $expected = '0';

        $auth = new \core\auth\Auth(array('db' => $db));
        $return = $auth->ldapAuthCheck($ldap, $domain_logon, $pass);

       // $this->assertEquals($expected, $return);
    }

    /**
     *
     * @runInSeparateProcess
     */
    public function testDestroySession()
    {
        $db = $this->getMockBuilder('db')
            ->getMock();

        $auth = new \core\auth\Auth(array('db' => $db));
        $return = $auth->destroySession();
        $this->assertArrayHasKey('1', $return);
        $this->assertTrue($return[0]);
        $this->assertTrue($return[1]);
    }




}
