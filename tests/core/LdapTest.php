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

require_once 'testing_config.php';

class LdapTest extends PHPUnit_Framework_TestCase
{
    public $config;
    public $ldap;

    public function setUp()
    {
        require_once '../src/core/auth/Ldap.php';
        require_once 'mocks/MockConfig.php';

        $config['ldap_key'] = md5('12345');
        $config['ldap_api_url'] = TEST_DIRECTORY . "/mocks/MockLdap.php";
        $config['environment'] = 'testing';

        $this->config = new MockConfig($config);
        $this->ldap = new \core\auth\Ldap(array('config' => $this->config));
    }

    public function tearDown() {}


    /**
     * @expectedException \Exception
     */
    public function testNullConstructor()
    {
        $class = new \core\auth\Ldap();
    }

    public function testPasswordEncrypt()
    {

        $string = 'testpass';
        $result = $this->ldap->passwordEncrypt($string);
        $this->assertEquals('116101115116112097115115', $result);
    }

    public function testRequestLdapVerificationFail()
    {
        $result = explode(',', $this->ldap->requestLdapVerification('ap2', 'test'));
        $this->assertEquals('X', $result[0]);
    }

    public function testRequestLdapVerification()
    {
        $result = explode(',', $this->ldap->requestLdapVerification('ap2', 'testpass'));
        $this->assertEquals('Andrew', $result[0]);
    }

    /**
     * @expectedException \Exception
     */
    public function testRequestLdapVerificationException()
    {

        $config['ldap_key'] = md5('12345');
        $config['ldap_api_url'] = TEST_DIRECTORY . "/mocks/MockLdapEmpty.php";
        $config['environment'] = 'testing';

        $cfg = new MockConfig($config);
        $ldap = new \core\auth\Ldap(array('config' => $cfg));

        $result = explode(',', $ldap->requestLdapVerification('ex1', 'test'));
       // $this->assertEquals('X', $result[0]);
    }

    /**
     * @expectedException \Exception
     */
    public function testRequestLdapVerificationExceptionDevelopment()
    {

        $config['ldap_key'] = md5('12345');
        $config['ldap_api_url'] = TEST_DIRECTORY . "/mocks/MockLdapEmpty.php";
        $config['environment'] = 'development';

        $cfg = new MockConfig($config);
        $ldap = new \core\auth\Ldap(array('config' => $cfg));

        $result = explode(',', $ldap->requestLdapVerification('ex1', 'test'));
        // $this->assertEquals('X', $result[0]);
    }

    /**
     * @expectedException \Exception
     */
    public function testMockConfigFail()
    {
        $config['ldap_key'] = md5('12345');
        $config['ldap_api_url'] = "http://pimsflight.dev/tests/mocks/MockLdapEmpty.php";

        $cfg = new MockConfig();
    }

    /**
     * @runInSeparateProcess
     */
    public function testRequestLdapVerificationDevelopment()
    {
        $config['ldap_key'] = md5('12345');
        $config['ldap_api_url'] = TEST_DIRECTORY . "/mocks/MockLdap.php";
        $config['environment'] = 'development';


        $cfg = new MockConfig($config);
        $ldap = new \core\auth\Ldap(array('config' => $cfg));

        $result = explode(',', $ldap->requestLdapVerification('ap2', 'test'));
        $this->assertEquals('Andrew', $result[0]);
    }

    public function testRequestLdapVerificationFailDevelopment()
    {

        $config['ldap_key'] = md5('12345');
        $config['ldap_api_url'] = TEST_DIRECTORY . "/mocks/MockLdap.php";
        $config['environment'] = 'development';


        $cfg = new MockConfig($config);
        $ldap = new \core\auth\Ldap(array('config' => $cfg));

        $result = explode(',', $ldap->requestLdapVerification('ap2', 'test2'));
        $this->assertEquals('X', $result[0]);
    }
}
