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

class Ldap
{
    /**
     * REQUIRED DEPENDENCIES
     */
    public $config; // application configuration


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
     * Send a request to the LDAP API
     *
     * @param $domain_logon
     * @param $pass
     * @return string
     * @throws \Exception
     */
    public function requestLdapVerification($domain_logon, $pass)
    {
        // Override the api for development mode
        if($this->config->item('environment') == 'development') {
            if ($domain_logon == 'ap2' && $pass == 'test') {
                return('Andrew,Podner,ap2@sigmaco.com,ap2');
            } elseif ($domain_logon == 'ex1') {
                throw new \Exception('Authorization API Error');
            } else {
                return('X,X,X,X');
            }
        }
        // END OVERRIDE FOR DEVELOPMENT

        // Encrypt the Password
        $encrypted = $this->passwordEncrypt($pass);

        // Query the API
        $file =  $this->config->item('ldap_api_url')
                 . "?k=" . $this->config->item('ldap_key')
                 . "&u=" . strtoupper($domain_logon)
                 . "&p=". $encrypted;

        // get the API Response
        if ( ! file_get_contents($file)) {
            throw new \Exception('Authorization API Error');
        } else {
            return file_get_contents($file);
        }
    }


    /**
     * Encrypt the password per SIGMA LDAP Login specification
     * @param string $string User's unencrypted password
     * @return string  ascii representation of encrypted password
     */
    public function passwordEncrypt($string)
    {
        $ascii = null;
        for ($i = 0; $i < strlen($string); $i++) {
            $next_char = str_pad(ord($string[$i]), 3, "0", STR_PAD_LEFT);
            $ascii .= $next_char;
        }
        return($ascii);
    }
}
