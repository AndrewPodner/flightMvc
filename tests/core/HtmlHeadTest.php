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
require_once '../src/core/helper/HtmlHead.php';
require_once '../src/core/lib/Config.php';


class HtmlHeadTest extends PHPUnit_Framework_TestCase
{
    public $config;
    public $class;

    public function setUp()
    {
        $config = array(
            'default_title' => 'Test123'
        );
        $this->config = new \core\lib\Config($config);
        $this->class = new \core\helper\HtmlHead(array('config' => $this->config));

    }

    public function tearDown() {}

    public function testConstructor()
    {
        $dep = array('config' => $this->config);
        $class = new \core\helper\HtmlHead($dep);
        $this->assertEquals('Test123', $class->_title);
    }

    /**
     * @expectedException \Exception
     */
    public function testConstructorFail()
    {
        $class = new \core\helper\HtmlHead();
    }

    public function testStyle()
    {
        $this->class->style(array('testStyle'));

        $result = is_numeric(strpos($this->class->_styles[0], 'testStyle'));
        $this->assertTrue($result);
    }


    /**
 * @expectedException \Exception
 */
    public function testStyleNoParam()
    {
        $this->class->style();
    }

    /**
     * @expectedException \Exception
     */
    public function testStyleEmptyParam()
    {
        $this->class->style(array());
    }

    /**
     * @expectedException \Exception
     */
    public function testScriptNoParam()
    {
        $this->class->script();
    }

    /**
     * @expectedException \Exception
     */
    public function testScriptEmptyParam()
    {
        $this->class->style(array());
    }

    public function testScript()
    {
        $this->class->script(array('testScript'));

        $result = is_numeric(strpos($this->class->_scripts[0], 'testScript'));
        $this->assertTrue($result);
    }

    public function testTitle()
    {
        $this->class->title('NewTitle');
        $title = $this->class->_title;
        $this->assertEquals('NewTitle', $title);
    }

    /**
     * @expectedException \Exception
     */
    public function testTitleNull()
    {
        $this->class->title();
    }

    public function testHead()
    {
        $this->class->script(array('testScript'));
        $this->class->style(array('testStyle'));
        $head = $this->class->head();
        $result = strpos($head, 'testScript');
        $this->assertTrue(is_numeric($result));
    }
}
