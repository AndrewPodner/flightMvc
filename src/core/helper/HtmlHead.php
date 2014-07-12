<?php
/**
 * File Description:
 *
 * @category   helper
 * @package    core
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */
namespace core\helper;
class HtmlHead
{
    /**
     * Configuration Dependency
     * @var Config
     */
    public $config;

    /**
     * Array of script tags
     * @var array
     */
    public $_scripts = array();

    /**
     * Array of style tags
     * @var array
     */
    public $_styles = array();

    /**
     * Page Title
     * @var
     */
    public $_title;

    public function __construct(array $arrDep = array())
    {
        // Load Dependencies
        if (empty($arrDep)) {
            throw new \Exception('Dependency Failure');
        } else {
            foreach ($arrDep as $key => $object) {
                $this->$key = $object;
            }
        }

        // Set the default page title
        $this->_title =  $this->config->item('default_title');
    }

    /**
     * Adds a Javascript File to the Array for the HTML HEAD
     * @param array $arrFile
     * @return Controller
     * @throws \Exception
     */
    public function script(array $arrFile = array())
    {
        if (empty($arrFile)) {
            throw new \Exception('No JavaScript Files Provided');
        }
        foreach($arrFile as $file) {
            $script = '<script type="text/javascript" src="./web/scripts/'.$file.'.js"></script>';
            $this->_scripts[] = $script;
        }
        return $this;
    }

    /**
     * Adds a CSS File to the Array for the HTML HEAD
     * @param array $arrFile
     * @return Controller
     * @throws \Exception
     */
    public function style(array $arrFile = array())
    {
        if (empty($arrFile)) {
            throw new \Exception('No CSS Files Provided');
        }
        foreach($arrFile as $file) {
            $style = '<link rel="stylesheet" href="./web/css/'.$file.'.css" />';
            $this->_styles[] = $style;
        }
        return $this;
    }

    /**
     * Changes the Page Title from the default
     * @param string $title
     * @return Controller
     * @throws \Exception
     */
    public function title($title = null)
    {
        if (is_null($title)) {
            throw new \Exception('No Title Provided');
        }
        $this->_title = $title;
        return $this;
    }

    /**
     * Returns the HTML HEAD Contents
     * @return string
     */
    public function head()
    {
        $head = '';
        if ( ! empty($this->_scripts)) {
            foreach($this->_scripts as $link) {
                $head .= $link . '
                ';
            }
        }
        if ( ! empty($this->_styles)) {
            foreach($this->_styles as $link) {
                $head .= $link . '
                ';
            }
        }
        $head .= '<title>'.$this->_title.'</title>
        ';
        return $head;
    }
}
