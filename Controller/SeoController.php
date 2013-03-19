<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James
 * Date: 19/03/13
 * Time: 12:35
 * To change this template use File | Settings | File Templates.
 */
class SeoController extends AppController {

    var $uses = array();
    var $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('robots'));
    }

    function robots()
    {
        if (Configure::read('debug'))
        {
            Configure::write('debug', 0);
        }

        //URLS we do not want indexed/crawled
        $urls = array(
            '/Actions',
            '/Artefacts',
            '/Conditions',
            '/CourseProfile',
            '/Customers',
            '/DimensionVerbs',
            '/Groups',
            '/Members',
            '/Memberships',
            '/Modules',
            '/People',
            '/Roles',
            '/Rules',
            '/Stats',
            '/Systems',
            '/UserProfile',
            '/Users'
        );

        $this->set(compact('urls'));
        $this->RequestHandler->respondAs('text');
        $this->viewPath .= '/text';
        $this->layout = 'ajax';
    }

}
