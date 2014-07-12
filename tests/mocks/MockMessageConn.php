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
class MockMessageConn
{
    public $affected_rows;
    public $num_rows;

    public function query($sql)
    {
        return new MockMessageRs();
    }

    public function real_escape_string($data)
    {

    }


}

class MockMessageRs {

    public function __construct()
    {
        $this->num_rows = 1;
        $this->counter = 0;
    }

    public function fetch_assoc()
    {
        if ($this->counter == 0) {
            $this->counter++;
            return array('body' => 'apples');
        } else {
            return false;
        }
    }

    public function fetch_fields() {
        $obj1 = new MockFields('apples');
        $obj2 = new MockFields('oranges');
        $obj3 = new MockFields('peaches');
        return array($obj1, $obj2, $obj3);
    }

}

class MockFields {
    public function __construct($data)
    {
        $this->name = $data;
        return $this;
    }
}