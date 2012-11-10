<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $helpers = array('MenuBuilder.MenuBuilder');

    //TODO - set active?
    function beforeFilter() {
        // Define your menu
        $menu = array(
            'main-menu' => array(
                array(
                    'title' => 'Home',
                    'url' => array('controller' => 'pages', 'action' => 'home'),
                ),
                array(
                    'title' => 'About Us',
                    'url' => '/pages/about-us',
                ),
            ),
            'left-menu' => array(
                array(
                    'title' => 'Involvement',
                    'children' => array(
                        array(
                            'title' => 'Overview',
                            'url' => array('controller' => $this->name, 'action' => 'overview', 3),
                        ),
                        array(
                            'title' => 'Location Access',
                            'url' => array('controller' => $this->name, 'action' => 'location', 4),
                        ),
                    )
                ),
                array(
                    'title' => 'Interaction',
                    'children' => array(
                        array(
                            'title' => 'Modules',
                            'url' => array('controller' => $this->name, 'action' => 'modules', 3),
                        ),
                        array(
                            'title' => 'Task Type',
                            'url' => array('controller' => $this->name, 'action' => 'tasktype', 4),
                        ),
                    )
                ),
            ),
        );

        // For default settings name must be menu
        $this->set(compact('menu'));
    }
}
