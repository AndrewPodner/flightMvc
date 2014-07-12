<?php
/**
* File Description: View for the login screen
*
* @category   view
* @package
* @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */



if (isset($login_message)) {
     echo '<div align="center" style="color:#FF0000;">'.
                $login_message .
           '</div>';
}
 $f = new \core\helper\Form('frmLogin');

 ?>
<h2 align="center">You Must Be Logged In to Access This System</h2>
     <table class="bodyText" align="center" width="400" bgcolor="#FFFFFF">
 		 <tr>
 		  <td width="200">User Name</td>
                  <td><?php $f->text('uid'); ?></td>
 		 </tr>
 		 <tr>
 		   <td>Password</td>
 		   <td><?php $f->password('pass'); ?></td>
 		 </tr>

 		<tr>
            <td align="center" colspan="2">
 			<?php $f->hidden("sub", "login"); ?>
                        <?php $f->submit('Login', 3, 'Login'); ?>
            </td>
 		 </tr>
 	  </table>


 <?php
 $f->fend();

 ?>
 <div>&nbsp;</div>



