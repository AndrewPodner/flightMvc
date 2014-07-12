<?php
/**
 * File Description:  Application Route Definitions
 * Sets up a route to implement a traditional MVC Controller feature
 * into the Flight Micro-framework
 *
 * @category   core
 * @package    core
 * @author     Andrew Podner <andy@unassumingphp.com>
 * @copyright  2013
 * @license    /license.txt
 */

// Remap the not found function
Flight::map('notFound', function(){
    Flight::render('404.php');
});

// Set up a route handler for Application Controllers
// Route accepts a controller, command and 2 arguments
Flight::route('(/@controller(/@command(/@arg1(/@arg2))))', function($controller, $command, $arg1, $arg2) {

    // Set `home` as the default controller
    if ( ! isset($controller)) {
        $controller = 'home';
    }

    // Set `index` as the default route
    if ( ! isset($command)) {
        $command = 'index';
    }

    // Set the controller name and command as config variables
    \Flight::config()->set('controller', $controller);
    \Flight::config()->set('command', $command);

    // Build a fully qualified controller name
    $fqController = '\app\controller\\' . ucfirst($controller);

    try {
        // Put parameters into array
        $arrParam = array($arg1, $arg2);

        // Designate Dependencies to Pass into Controller
        $arrDep = array(
            'config' => Flight::config(),
            'input' => Flight::input()
        );

        // Check for the controller, if it doesn't exist, go to 404
        if ( ! class_exists($fqController)) {
            Flight::render('404.php');
            Flight::stop();
        }

        // Load the controller & call the designated method
        $ctrl = new $fqController($arrDep, $arrParam);

        // Return a 404 error if the command is not valid
        if ( ! method_exists($fqController, $command)) {
            Flight::render('404.php');
        } else {

            // Here we are going to apply user access control unless the page is the login or logout page
            // Exception:  this will also run if the user has submitted the login form
            if (Flight::config()->item('enable_auth') === true) {
                if ( ! in_array(Flight::config()->item('command'), array('login', 'logout'))
                    || (isset(Flight::input()->post['sub']) && Flight::input()->post['sub'] == 'login')) {

                    if (Flight::config()->item('environment') !== 'development') {
                        // Load the login details into an array
                        $arrLogin = array();
                        if (isset(Flight::input()->post['sub'])) {
                            $arrLogin['sub'] = Flight::input()->post['sub'];
                            $arrLogin['uid'] = Flight::input()->post['uid'];
                            $arrLogin['pass'] = Flight::input()->post['pass'];
                        }

                        // Load the persistent info into an array
                        $arrPers = array();
                        if (isset(Flight::input()->cookie['pimsId']) && isset(Flight::input()->cookie['pimsToken'])) {
                            $arrPers['pimsId'] = Flight::input()->cookie['pimsId'];
                            $arrPers['pimsToken'] = Flight::input()->cookie['pimsToken'];
                        }

                        // Initialize Auth Class
                        $auth = new \core\auth\Auth(
                            array(
                                'config' => Flight::config(),
                                'db' => Flight::db()
                            )
                        );

                        // Run ACL Check (deps: Ldap and User)
                        $ldap = new \core\auth\Ldap(array('config' => Flight::config()));
                        $user = new \core\auth\User(array('db' => Flight::db()));
                        $action = $auth->checkValidSession($arrPers, $arrLogin, $user, $ldap);

                        // Execute the proper action based on the ACL response
                        switch ($action) {
                            case 'load':
                                $ctrl->$command();
                                break;
                            case 'home':
                                Flight::redirect('/home/index');
                                break;
                            case 'login':
                                Flight::redirect('/home/login');
                                break;
                            case 'failed':
                                Flight::input()->session('login_message', 'Username / Password Combination Failed!');
                                Flight::redirect('/home/login');
                                break;
                        }
                    } else {
                        $ctrl->$command();
                    }

                } else {
                    $ctrl->$command();
                }

            // If we are not running ACL procedures, load the page (login page)
            } else {
                $ctrl->$command();
            }
        }

    } catch (\Exception $e) {
        echo $e->getMessage();
    }
});


// Catch all route for undefined routes
Flight::route('*', function() {
    Flight::render('404.php');
});