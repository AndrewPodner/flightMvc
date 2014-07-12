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
class MockPDO extends PDO {

    const FETCH_ASSOC = 1;
    const PARAM_STR = 1;

    public $conn;

    public function __construct()
    {
        $this->conn = new MockConn();
    }

    public function updateUserRightsById() {}

}

class MockConn
{
    public function prepare()
    {
        return new PrepStmt();
    }
}


class PrepStmt {
    public function bindParam() {}

    public function execute()
    {

    }

    public function fetch() {}
}
