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
require_once '../src/core/helper/Filter.php';
require_once '../src/core/auth/Auth.php';

class AuthExt extends  core\auth\Auth
{
    public function __construct($dep)
    {
        parent::__construct($dep);
    }

    public function checkPersistentLogin($token, $id)
    {
        return 1;
    }

    public function ldapAuthCheck(\core\auth\Ldap $ldap, $domain_logon, $pass)
    {
        if($domain_logon == 'tu') {
            return array('logon' => 'TU');
        } else {
            return 0;
        }
    }

    public function createPersistentLogin($uid, $salt)
    {
        if ($salt == 'throw') {
           return 0;
        } else {
            return 1;
        }
    }
}





class AuthSessionTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    /**
     * @runInSeparateProcess
     */
    public function testCheckValidSessionPersistentLoginSuccess()
    {
        $arrPers = array('pimsId' =>  'abc123', 'pimsToken' => 'def456');
        //$arrLogin = array('sub' => 'login', 'uid' =>  'tu', 'pass' => 'testpass');

        $config = $this->getMockBuilder('config')
            ->setMethods(array('set','item'))
            ->getMock();

        $config->expects($this->any())
            ->method('set')
            ->will($this->returnSelf());

        $config->expects($this->any())
            ->method('item')
            ->will($this->returnValue('saltPhraseTest'));

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        $ldap->expects($this->any())
            ->method('requestLdapVerification')
            ->will($this->returnValue('Test,User,test@user.com,tu'));


        $user = $this->getMockBuilder('core\auth\User')
            ->disableOriginalConstructor()
            ->setMethods(array('getUserInfo'))
            ->getMock();

        $user->expects($this->any())
            ->method('getUserInfo')
            ->will($this->returnValue('1'));

        $dep = array('config' => $config);
        $auth = new AuthExt($dep);
        $return = $auth->checkValidSession(
            $arrPers, array(), $user, $ldap
        );

        $expected = 'load';
        $this->assertEquals($expected, $return);
    }


    /**
     * @runInSeparateProcess
     */
    public function testCheckValidSessionPersistentLoginFail()
    {
        $arrPers = array('pimsId' =>  'abc123');
        //$arrLogin = array('sub' => 'login', 'uid' =>  'tu', 'pass' => 'testpass');

        $config = $this->getMockBuilder('config')
            ->setMethods(array('set', 'item'))
            ->getMock();

        $config->expects($this->any())
            ->method('set')
            ->will($this->returnSelf());

        $config->expects($this->any())
            ->method('item')
            ->will($this->returnValue('saltPhraseTest'));

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        $ldap->expects($this->any())
            ->method('requestLdapVerification')
            ->will($this->returnValue('Test,User,test@user.com,tu'));


        $user = $this->getMockBuilder('core\auth\User')
            ->disableOriginalConstructor()
            ->setMethods(array('getUserInfo'))
            ->getMock();

        $user->expects($this->any())
            ->method('getUserInfo')
            ->will($this->returnValue('1'));

        $dep = array('config' => $config);
        $auth = new AuthExt($dep);
        $return = $auth->checkValidSession(
            $arrPers, array(), $user, $ldap
        );

        $expected = 'login';
        $this->assertEquals($expected, $return);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCheckValidSessionSubmitLoginSuccess()
    {
        $arrLogin = array('sub' => 'login', 'uid' =>  'tu', 'pass' => 'testpass');

        $config = $this->getMockBuilder('config')
            ->setMethods(array('set','item'))
            ->getMock();

        $config->expects($this->any())
            ->method('set')
            ->will($this->returnSelf());

        $config->expects($this->any())
            ->method('item')
            ->will($this->returnValue('saltPhraseTest'));

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        $ldap->expects($this->any())
            ->method('requestLdapVerification')
            ->will($this->returnValue('Test,User,test@user.com,tu'));


        $user = $this->getMockBuilder('core\auth\User')
            ->disableOriginalConstructor()
            ->setMethods(array('getUserInfo'))
            ->getMock();

        $user->expects($this->any())
            ->method('getUserInfo')
            ->will($this->returnValue(array('id' => 1, 'username' => 'Andrew')));

        $dep = array('config' => $config);
        $auth = new AuthExt($dep);
        $return = $auth->checkValidSession(
            array(), $arrLogin, $user, $ldap
        );

        $expected = 'home';
        $this->assertEquals($expected, $return);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCheckValidSessionSubmitLoginFail()
    {
        $arrLogin = array('sub' => 'login', 'uid' =>  'fail', 'pass' => 'testpass');

        $config = $this->getMockBuilder('config')
            ->setMethods(array('set','item'))
            ->getMock();

        $config->expects($this->any())
            ->method('set')
            ->will($this->returnSelf());

        $config->expects($this->any())
            ->method('item')
            ->will($this->returnValue('saltPhraseTest'));

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        $ldap->expects($this->any())
            ->method('requestLdapVerification')
            ->will($this->returnValue('Test,User,test@user.com,tu'));


        $user = $this->getMockBuilder('core\auth\User')
            ->disableOriginalConstructor()
            ->setMethods(array('getUserInfo'))
            ->getMock();

        $user->expects($this->any())
            ->method('getUserInfo')
            ->will($this->returnValue('1'));

        $dep = array('config' => $config);
        $auth = new AuthExt($dep);
        $return = $auth->checkValidSession(
            array(), $arrLogin, $user, $ldap
        );

        $expected = 'failed';
        $this->assertEquals($expected, $return);
    }

    /**
     * @expectedException \Exception
     * @runInSeparateProcess
     *
     */
    public function testCheckValidSessionSubmitThrowException()
    {
        $arrLogin = array('sub' => 'login', 'uid' =>  'tu', 'pass' => 'testpass');

        $config = $this->getMockBuilder('config')
            ->setMethods(array('set','item'))
            ->getMock();

        $config->expects($this->any())
            ->method('set')
            ->will($this->returnSelf());

        $config->expects($this->any())
            ->method('item')
            ->will($this->returnValue('throw'));

        $ldap = $this->getMockBuilder('core\auth\Ldap')
            ->disableOriginalConstructor()
            ->setMethods(array('requestLdapVerification'))
            ->getMock();

        $ldap->expects($this->any())
            ->method('requestLdapVerification')
            ->will($this->returnValue('Test,User,test@user.com,tu'));


        $user = $this->getMockBuilder('core\auth\User')
            ->disableOriginalConstructor()
            ->setMethods(array('getUserInfo'))
            ->getMock();

        $user->expects($this->any())
            ->method('getUserInfo')
            ->will($this->returnValue('0'));

        $dep = array('config' => $config);
        $auth = new AuthExt($dep);
        $return = $auth->checkValidSession(
            array(), $arrLogin, $user, $ldap
        );

        $expected = 'failed';
        //$this->assertEquals($expected, $return);
    }
}
