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
use core\data\PdoConn;
use core\lib\Config;
require_once '../src/core/data/PdoConn.php';
require_once '../src/core/lib/Config.php';

class PdoConnTest extends PHPUnit_Framework_TestCase
{
    public $db;
    public $conf;
    public $insert_id;

    public function setUp()
    {
        $config['db_default']['host'] = 'localhost:8889';
        $config['db_default']['db_user'] = 'root';
        $config['db_default']['db_password'] = 'mysql';
        $config['db_default']['db_name'] = 'pims';
        $config['db_default']['driver'] = 'mysql';
        $config['db_prefix'] = 'PIMS_';
        $this->conf = new Config($config);

        $this->db = new PdoConn(array('config' => $this->conf));
    }

    public function tearDown()
    {
        $this->db = null;

    }


    public function testMysqlConnection()
    {
        $this->assertObjectHasAttribute('conn', $this->db);
    }

    /**
     * @expectedException \Exception
     */
    public function testSqlServerConnectionAndConnFailure()
    {
        $config2['db_default']['dsn'] = 'localhost:1433';
        $config2['db_default']['db_user'] = 'root';
        $config2['db_default']['db_password'] = 'mysql';
        $config2['db_default']['driver'] = 'sqlsrv';
        $config2['db_prefix'] = 'PIMS_';
        $conf2 = new Config($config2);
        $db3 = new PdoConn(array('config'=>$conf2));
        $db3 = null;
    }

    /**
     * @expectedException \Exception
     */
    public function testOdbcConnectionAndConnFailure()
    {
        $config2['db_default']['dsn'] = 'localhost:8889';
        $config2['db_default']['db_user'] = 'root';
        $config2['db_default']['db_password'] = 'mysql2';
        $config2['db_default']['driver'] = 'odbc';
        $config2['db_prefix'] = 'PIMS_';
        $conf2 = new Config($config2);
        $db3 = new PdoConn(array('config'=>$conf2));
        $db3 = null;
    }

    /**
     * @expectedException \Exception
     */
    public function testConnectionDependencyFailure()
    {
        $db = new PdoConn(array());
    }

    /**
     *
     */
    public function testConnectionWithName()
    {
        $db2 = new PdoConn(array('config' => $this->conf), 'default');
        $this->assertObjectHasAttribute('conn', $db2);
        $db2 = null;
    }


    /**
     *
     */
    public function testInit()
    {
        $db2 = new PdoConn(array('config' => $this->conf), 'default');
        $db2->init();
        $this->assertObjectHasAttribute('conn', $db2);
        $db2 = null;
    }

    public function testOverloadGet()
    {
        $arrOutput = $this->db->getCompaniesById(1);
        $this->assertArrayHasKey('abbr', $arrOutput[0]);
    }


    /**
     * @expectedException \PDOException
     */
    public function testOverloadGetFail()
    {
        $arrOutput = $this->db->getCompaniesByIx(1);
        //$this->assertArrayHasKey('abbr', $arrOutput[0]);
    }

    public function testOverloadFiler()
    {
        $arrOutput = $this->db->filterCompaniesById(1);
        $this->assertArrayHasKey('abbr', $arrOutput[0]);
    }
    public function testFilterSort()
    {
        $arrOutput = $this->db->filter('pims_companies', 'id', '1', 'abbr');
        $this->assertArrayHasKey('abbr', $arrOutput[0]);
    }


    public function testFilter()
    {
        $arrOutput = $this->db->filter('pims_companies', 'id', 1);
        $this->assertArrayHasKey('abbr', $arrOutput[0]);

        $arrOutput = $this->db->filter('pims_companies', 'id', '1*');
        $this->assertArrayHasKey('abbr', $arrOutput[0]);


    }

    /**
     * @expectedException \PDOException
     */
    public function testFilterFail()
    {
        $arrOutput = $this->db->filter('companies', 'ix', 1);
        //$this->assertArrayHasKey('abbr', $arrOutput[0]);
    }

    public function testOverloadInsert()
    {
        $arr = array(
            'abbr' => "TST",
            'descr' => "TEST COMPANY",
        );
        $result = $this->db->insertCompanies($arr);
        $this->insert_id = $result;
        $rs = $this->db->getCompaniesById($result);
        $this->assertArrayHasKey('abbr', $rs[0]);
        $this->assertEquals('TST', $rs[0]['abbr']);
    }

    /**
     * @expectedException \PDOException
     */
    public function testOverloadInsertFail()
    {
        $arr = array(
            'abbrev' => "TST",
            'descr' => "TEST COMPANY",
        );
        $result = $this->db->insertCompanies($arr);

    }

    public function testOverloadUpdate()
    {

        $arr = array('abbr' => 'TTS');
        $this->db->updateCompaniesByAbbr('TST' , $arr);
        $rs = $this->db->getCompaniesByAbbr('TTS');
        $this->assertArrayHasKey('abbr', $rs[0]);
        $this->assertEquals('TTS', $rs[0]['abbr']);
    }

    /**
     * @expectedException \PDOException
     */
    public function testOverloadUpdateFail()
    {
        $arr = array('abbrev' => 'TTS');
        $this->db->updateCompaniesById('TST', $arr);
    }

    public function testOverloadDelete()
    {

        $rs = $this->db->deleteCompaniesByAbbr('TTS');
        $this->assertEquals(1, $rs);
    }

    /**
     * @expectedException \PDOException
     */
    public function testOverloadDeleteFail()
    {
        $rs = $this->db->deleteCompaniesByIx('TTS');
    }

    public function testOverloadGetAll()
    {
        $rs = $this->db->allCompanies();
        $this->assertArrayHasKey('abbr', $rs[0]);
    }

    /**
     * @expectedException \PDOException
     */
    public function testOverloadGetAllFail()
    {
        $rs = $this->db->allCompaniess();
    }


    public function testCamelCaseToUnderscore()
    {
        $val = 'SomeTest';
        $expected = 'some_test';
        $ret = $this->db->camelCaseToUnderscore($val);
        $this->assertEquals($expected, $ret);
    }


}
