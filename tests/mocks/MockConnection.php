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
namespace app\mocks;
class MockConnection
{
    public $affected_rows;
    public $num_rows;

    public function query($sql)
    {
        if (is_string($sql) && stristr($sql, "SELECT * FROM")) {
            return new MockRecordset();
        } else {
            $this->affected_rows = 1;
        }
        return $this;
    }


}

class MockRecordset {

    public function __construct()
    {
        $this->num_rows = 1;
    }

    public function fetch_assoc()
    {
        return array('apples', 'oranges', 'pears');
    }




}