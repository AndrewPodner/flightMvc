<?php
/**
 * File Description:
 *
 * @category   auth
 * @package    core
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
namespace core\auth;
use \core\helper\Filter;

class Auth
{
    /**
     * REQUIRED DEPENDENCIES
     */
    public $db;  // data connection
    public $config; // configuration

    /**
     * Is the user authenticated against the LDAP Server, assume not. (1 = yes)
     * @var int
     */
    public $ldap_authenticated = 0;

    /**
     * Is the user logged into the system, assume no (1 = yes)
     * @var int
     */
    public $user_logged_in = 0;



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
     * Given a token and unique id, check for a valid persistent login
     * @param $token
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function checkPersistentLogin($token, $id)
    {
        // Assume Recordset is Empty
        $return = false;

        // Filter the token & id
        if (Filter::alphanumeric($token) === false || Filter::alphanumeric($id) === false) {
            throw new \Exception('Invalid Token/Id');
        }

        // Look up the Token and Identifier in the Database
        $stmt = $this->db->conn->prepare("SELECT id FROM PIMS_user_rights WHERE
                unique_id = :id AND  token = :token");
        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();

        // If there is a match, return the user's id otherwise false
        if ($stmt !== false) {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $return = $row['id'];
        }
        return $return;

    }

    /**
     * Updates the persistent login information in the database for future access
     * @param int $uid  id in the user table
     * @param string $salt Salt phrase for auth system
     * @return boolean false on failure
     */
    public function createPersistentLogin($uid, $salt)
    {
        $token = md5($salt.time());
        $uniqueId = uniqid();

        setcookie('pimsId', $uniqueId, time()+(2592000));
        setcookie('pimsToken', $token, time()+(2529000));

        $result = $this->db->updateUserRightsById($uid,
            array(
                'token' => $token,
                'unique_id' => $uniqueId
            )
        );
        return $result;
    }

    /**
     * Validate the user's domain login via LDAP
     * @param Ldap $ldap
     * @param $domain_logon
     * @param $pass
     * @return mixed
     * @throws \Exception
     */
    public function ldapAuthCheck(Ldap $ldap, $domain_logon, $pass)
    {
        if (Filter::alphanumeric($domain_logon) !== true) {
            throw new \Exception('Invalid Login Name');
        }

        $data = $ldap->requestLdapVerification($domain_logon, $pass);

        $return_info = explode(',', $data);
        if ($return_info[1] == "X") {
            $user = 0;
        } else {
            $user['logon'] = strtoupper($return_info[3]);
            $user['fname'] = $return_info[0];
            $user['lname'] = $return_info[1];
            $user['email'] = $return_info[2];
            $user['uname'] = $return_info[0].chr(32).$return_info[1];
        }
        unset($ldap);
        return $user;
    }




    /**
     * Destroys the cookies on the user's client to kill the session
     * @return boolean true on success
     */
    public function destroySession()
    {
        return array(
            setcookie('pimsId', 'nothing', time()-100),
            setcookie('pimsToken', 'nothing', time()-100)
        );
    }

    /**
     * Primary security mechanism.  Assures that a user is authenticated with a
     * persistent login.  If not, it will redirect to the login screen.  This
     * will also control the processing of a submitted login.
     *
     * @param array $arrPers  Persistent Login Details
     * @param array $arrLogin Submitted Login Attempt Details
     * @param User $user
     * @param Ldap $ldap
     * @return bool|string
     * @throws \Exception
     */
    public function checkValidSession(
        array $arrPers = array(),
        array $arrLogin = array(),
        User $user = null,
        Ldap $ldap = null)
    {
        // Check to see if we have a valid persistent login set
        if (array_key_exists('pimsToken', $arrPers) && array_key_exists('pimsId', $arrPers)) {
            $valid = $this->checkPersistentLogin($arrPers['pimsToken'], $arrPers['pimsId']);
        } else {
            $valid = false;
        }

        if ($valid !== false) {
            // If there is, get the user's id and load the user's information as
            // a configuration item.
            $userInfo = $user->getUserInfo(array('id' => $valid));
            $this->config->set('user', $userInfo);
            return 'load';

            // If there is no valid persistent login, check for a login attempt
        } else {

            // If a login form was submitted
            if (array_key_exists('sub', $arrLogin) && $arrLogin['sub'] == 'login') {

                // Verify the login attempt
                $login = $this->ldapAuthCheck($ldap, $arrLogin['uid'], $arrLogin['pass']);

                // If the login attempt succeeds...
                if ($login !== 0) {

                    // Put the user's information into the config object
                    $userInfo = $user->getUserInfo(array('username' => $login['logon']));
                    $this->config->set('user', $userInfo);

                    // Set up a persistent session
                    $action = $this->createPersistentLogin($userInfo['id'], $this->config->item('auth_salt_phrase'));
                    return 'home';

                    // Otherwise, send them back to the login screen with a failure message
                } else {
                    return 'failed';
                }
                // No login form was submitted, send them back to the login screen
            } else {
                return 'login';
            }
        }
    }
}
