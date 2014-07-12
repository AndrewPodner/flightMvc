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
class MockConfig
{
    public $_config = array();

    public function __construct($config = null)
    {
        if (is_null($config)) {
            throw new \Exception('No Configuration Variables Found');
        }
        $this->_config = $config;
        return $this;
    }

    public function item($arg = null)
    {
        if (is_null($arg)) {
            return $this->_config;
        } else {
            return $this->_config[$arg];
        }
    }

    public function set($item, $val)
    {
        return true;
    }
}
