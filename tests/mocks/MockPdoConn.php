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
class MockPdoConn
{
    function get($p1 = null, $p2=null, $p3=null) {
        $ret[0]['table'] = $p1;
        return $ret;
    }
}
