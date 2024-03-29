<?php
/**
 * File Description:
 *
 * @category   lib
 * @package    core
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
namespace core\lib;
class Config
{
    /**
     * Configuration settings
     * @var array
     */
    public $_config = array();

    /**
     * Constructor: load configuration into property
     *
     * @param mixed $config
     * @return Config
     * @throws \Exception
     */
    public function __construct($config = null)
    {
        if (is_null($config)) {
            throw new \Exception('No Configuration Variables Found');
        }
        $this->_config = $config;
        return $this;
    }

    /**
     * Retrieve a configuration item. If no item
     * name is provided, return all settings
     *
     * @param null|string $arg
     * @return mixed
     */
    public function item($arg = null)
    {
        if (is_null($arg)) {
            return $this->_config;
        } else {
            return $this->_config[$arg];
        }
    }

    /**
     * Set a new item for the configuration, used for adding runtime
     * configuration properties
     *
     * @param string $varName
     * @param string $value
     * @return Config
     * @throws \Exception
     */
    public function set($varName = null, $value = null)
    {
        if (is_null($varName) || is_null($value)) {
            throw new \Exception('Invalid data passed to configuration set');
        }
        $this->_config[$varName] = $value;
        return $this;
    }
}
