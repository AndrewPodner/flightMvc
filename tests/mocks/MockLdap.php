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
//var_dump($_GET);

if($_GET['k'] == md5(12345)
        && $_GET['u'] == 'AP2'
        && $_GET['p'] == '116101115116112097115115'
    ) {
    echo 'Andrew,Podner,ap2@example.com,ap2';
} else {
    echo 'X,X,X,X';
}