<?php
/**
 * Class for HTML Form Generation
 *
 * @category Core
 * @author andy
 * @copyright (c) 2012
 * @license  /license.txt
 */
namespace core\helper;

class Form
{
    /**
     * Constructor
     * @param $id
     * @param string $action
     * @param int $method
     * @param null $addtl
     */
    public function __construct($id, $action = 's', $method = 1, $addtl = null)
    {
        switch ($method) {
            case 1:
                $meth = 'post';
                break;
            case 2:
                $meth = 'get';
                break;
        }

        if ($action == 's') {
            $action = '';
        }

        echo '<form id="'.$id.'" method="'.$meth.'" action="'.$action.'" '.$addtl.'>
        ';
    }


    /** @name: fend
     * @param: none
     * @returns: html string
     * @descr: generate the closing form tag
     *
     */
    public function fend()
    {
        echo '</form>
        ';
    }


    /** @name: button
     * @param: name=string, val=string, onlick=string
     * @returns: html string
     * @descr: generates the html for a form button
     *
     */
    public function button($name, $val, $onclick)
    {
        echo '<input type="button" id="'.$name.'" value="'.$val.'"
                     onclick="'.$onclick.'"  />';
    }


    /** @name: text
     * @param: name=string, val=string, size=int
     * @returns: html string
     * @descr: generates a text box input tag
     *
     */
    public function text($name, $val = "", $size = 40, $addtl = null)
    {
        $str = '<input type="text"
                       size="'.$size.'"
                       name="'.$name.'"
                       value="'.$val.'"
                       id="'.$name.'" '.$addtl.' />
                    ';
        echo $str;
    }


    /** @name: password
     * @param: name=string, size=int
     * @returns: html string
     * @descr: generates a password input tag
     *
     */
    public function password($name, $size = 40)
    {
        $str = '<input type="password"
                       name="'.$name.'"
                       id="'.$name.'"
                       size="'.$size.'" />
                    ';
        echo $str;
    }

    /** @name: hidden
     * @param: name=string, val=string
     * @returns: html string
     * @descr: generates a hidden input tag
     *
     */
    public function hidden($name, $val = "")
    {
        $str = '<input type="hidden"
                       name="'.$name.'"
                       value="'.$val.'"
                       id="'.$name.'" />
                    ';
        echo $str;
    }


    /** @name: submit
     * @param: name=string, val=string
     * @returns: html string
     * @descr: generates a submit button input tag
     *
     */
    public function submit($val = "Submit", $name = "Submit", $addtl = null)
    {
        $str = '<input type="submit"
                       name="'.$name.'"
                       value="'.$val.'"
                       id="'.$name.'"
                       '.$addtl.' />
                    ';
        echo $str;
    }


    /** @name: select
     * @param: name=string, opts=array, sel=string
     * @returns: html string
     * @descr: generates a select tag with options
     *          the $opts array should have the
     *          structure where the array key is
     *          in the value part of the option tag
     *          and the array element value is what the
     *          option tag will display
     *          put a string in sel paramter to denote
     *          which value if any is selected on load
     */
    public function select($name, $opts = '1', $sel = '', $addtl = null)
    {
        if ($opts == '1') {
            $opts = array(
                        0 => 'Yes',
                        1 => 'No');
        }

        $str = '<select '.$addtl.' name="'.$name.'" id="'.$name.'">
        ';
        foreach ($opts as $key => $value) {
            if ($key == $sel) {
                $str .= '<option value="'.$key.'"
                                 selected="selected">'.$value.'</option>
                ';
            } else {
                $str .= '<option value="'.$key.'">'.$value.'</option>
                ';
            }
        }
        $str .='</select>
        ';
        echo $str;
    }


    /**
     * @name: textarea
     * @params: name=string, val=string, attribs=string
     * @returns: html string
     * @descr: generates a textarea tag
     *         use attribs parameter to specify additional
     *         information like width and cols
     */
    public function textarea($name, $val = '', $attribs = '')
    {
        $str = '<textarea name="'.$name.'" '.$attribs.'>'.$val.'</textarea>
        ';
        echo $str;
    }

    /** @name: checkbox
     * @params: name=string, val=string, chk=int
     * @returns: html string
     * @descr: returns a check box form tag
     *         use a 1 in the chk parameter for a
     *         checked value
     */
    public function checkbox($name, $val, $chk = 0)
    {
        if ($chk == 1) {
            $str = '<input type="checkbox"
                           name="'.$name.'"
                           value="'.$val.'"
                           checked="yes" />
            ';
        } else {
            $str = '<input type="checkbox" name="'.$name.'" value="'.$val.'" />
            ';
        }
        echo $str;
    }
}
