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
namespace core\auth;
class User
{
    /**
     * Database Connection Dependency
     * @var
     */
    public $db;

    /**
     * User Login name
     * @var string
     */
    public $username;

    /**
     * User is active & authorized (1 = true)
     * @var int
     */
    public $is_user;

    /**
     * User is an administrator (1 = true)
     * @var
     */
    public $is_admin;

    /**
     * Full name of the user
     * @var string
     */
    public $full_name;

    /**
     * Persistent login token
     * @var string
     */
    public $token;

    /**
     * Persistent login unique id
     * @var
     */
    public $unique_id;



    /**
     *
     * @param array $arrDep
     * @throws \Exception
     */
    public function __construct(array $arrDep = array())
    {
        if (empty($arrDep)) {
            throw new \Exception('Dependency Failure');
        } else {
            foreach ($arrDep as $key => $object) {
                $this->$key = $object;
            }
        }
    }

    /**
     * Get user information based upon a db table field & value
     * @param array $arrUser ('fieldName' => 'value')
     * @return array
     * @throws \Exception
     */
    public function getUserInfo(array $arrUser)
    {
        $field = key($arrUser);
        $where = current($arrUser);

        $method = 'getUserRightsBy'.ucfirst($field);

        $result = $this->db->$method($where);
        if( ! empty($result)) {
            return $result[0];
        } else {
            throw new \Exception('User Data Not Found');
        }
    }

    /**
     * Updates the persistent login information in the database for future access
     * @param int $uid  id in the user table
     * @param string $token token for persistent login
     * @param string $uniqueId session's unique id for the persistent login
     * @return boolean false on failure
     */
    public function updateUserPersistentLogin($uid, $token, $uniqueId)
    {
        $result = $this->db->update(array('id' => $uid, 'token' => $token, 'unique_id' => $uniqueId ));
        if ($result != 0) {
            return $result;
        } else {
            return false;
        }
    }


}
