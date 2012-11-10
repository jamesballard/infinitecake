<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 21:37
 */
class UserprofileController extends AppController {
    public $helpers = array('Html', 'Form', 'Session', 'GChart.GChart', 'MenuBuilder.MenuBuilder');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('MdlUser', 'MdlLog');

    public function index() {
        $this->set('user',$this->MdlUser->getUser('37953'));
    }

    public function overview() {
        $this->set('user',$this->MdlUser->getUser('37953'));
    }

    public function location() {

    }

    public function modules() {

    }

    public function tasktype() {

    }

}
