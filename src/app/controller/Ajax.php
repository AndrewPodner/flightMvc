<?php
/**
 * File Description:  controller for Ajax Requests
 *
 * @category   controller
 * @package    spg
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
namespace app\controller;
class Ajax
{
    /**
     * URL Parameters 1 and 2
     * @var array
     */
    public $param = array();

    /**
     * Globally Available Connection to PDO Model
     * @var null
     */
    public $db = null;

    public function __construct($arrDep, $arrParam)
    {

        $this->param = $arrParam;
        $this->db = new \core\data\PdoConn(array('config' => \Flight::config()));
    }


}
