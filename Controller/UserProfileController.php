<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 21:37
 */
class UserprofileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'autoComplete.autoCompleteRemote');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'Person', 'User', 'FactSummedActionsDatetime', 'FactSummedVerbRuleDatetime');

    public function index() {
        //Create selected user as session variable.            
        $userid = $this->Session->read('Profile.user');
        if ($this->request->is('post')) {
            $user = $this->request->data['Action']['userid'];
            $this->set('userid', $user);
            $this->set('userdefault', $user);
            $this->Session->write('Profile.user', $user);
        }elseif($userid){
        	$selecteduser = $this->Person->find('first',array(
	        			'conditions' => array('id'=>$userid), //array of conditions
	        			'recursive' => -1, //int
	        			'fields' => array('idnumber'), //array of field names
	        		)
        	);
        	$this->set('userid', $userid);
            $this->set('userdefault', $selecteduser['Person']['idnumber']);
        }else{
        	$this->set('userid','');
            $this->set('userdefault','');
        }
    }

    public function overview() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
            //Set defaults
            $period = 'month';
            $chartType = 'area';
            $reportType = 'Activity';
            $system = 0;
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Action']['period'];
                $chartType = $this->request->data['Action']['chart'];
                $reportType = $this->request->data['Action']['report'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $data = array(
                'title' => $reportType,
                'type' => $chartType,
                'width' => $width,
                'height' => $height
            );
            $results = $this->getOverviewData($period, $system);
            $data = array_merge($data,$results);

            $systems = array(0=>'All');
            $systems = array_merge($systems, $this->FactSummedActionsDatetime->System->find('list'));
            $this->set(compact('systems'));

            $this->set('data', $data);
        }
    }

    public function location() {

    }
    
    public function stream() {
    
    }
    
    public function help() {
    
    }

    public function hourly() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
            //Set defaults
            $report = 'sum';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $report = $this->request->data['Action']['report'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);

            $userid = $this->Session->read('Profile.user');

            $dayData = $this->FactSummedActionsDatetime->getHourStats('day', $report, array('user_id'=>$userid));
            $dayData = base64_encode(serialize($dayData));

            $this->set('dayData', $dayData);

            $nightData = $this->FactSummedActionsDatetime->getHourStats('night', $report, array('user_id'=>$userid));
            $nightData = base64_encode(serialize($nightData));

            $this->set('nightData', $nightData);
        }
    }

    public function modules() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
            //Set defaults
            $reportType = 'Activity';
            $system = 0;
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $reportType = $this->request->data['Action']['report'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            $this->set('data', $this->getModuleData($system));

            $systems = array(0=>'All');
            $systems = array_merge($systems, $this->FactSummedActionsDatetime->System->find('list'));
            $this->set(compact('systems'));
        }
    }

    public function tasktype() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
            //Set defaults
            $period = 'month';
            $chartType = 'column';
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Action']['period'];
                $chartType = $this->request->data['Action']['chart'];
                $reportType = $this->request->data['Action']['report'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $data = array(
                'title' => $reportType,
                'type' => $chartType,
                'width' => $width,
                'height' => $height
            );
            if($chartType == ('bar' || 'column')) {
                $data['isStacked'] = true;
            }
            $results = $this->getTaskTypeData($period);
            $data = array_merge($data,$results);

            $this->set('data', $data);
        }
    }

    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getOverviewData($period, $system) {
        $userid = $this->Session->read('Profile.user');

        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M";
            break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W';
            break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M";
            break;
        }

        $user_ids = $this->User->find('list', array(
                'conditions' => array('person_id' => $userid), //array of conditions
                'recursive' => -1, //int
                'fields' => array('User.id'), //array of field names
            )
        );

        $conditions = array('user_id'=>$user_ids);
        if($system > 0) {
            $conditions = array_merge($conditions,array('FactSummedActionsDatetime.system_id' => $system));
        }
        $data = $this->FactSummedActionsDatetime->getPeriodCountGchart($conditions, $interval, $dateFormat);
        return $data;
    }

    /**
     * Contructs and returns module treemap data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getModuleData($system) {
        $userid = $this->Session->read('Profile.user');
        $user_ids = $this->User->find('list', array(
                'conditions' => array('person_id' => $userid), //array of conditions
                'recursive' => -1, //int
                'fields' => array('User.id'), //array of field names
            )
        );

        $conditions = array('user_id'=>$user_ids);
        if($system > 0) {
            $conditions = array_merge($conditions,array('FactSummedActionsDatetime.system_id' => $system));
        }
        $data = $this->FactSummedActionsDatetime->getModuleCountTreemap($conditions);
        return $data;
    }

    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getTaskTypeData($period) {
        $userid = $this->Session->read('Profile.user');

        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M-y";
                $data = $this->FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W-o';
                $data = $this->FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M-y";
                $data = $this->FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
        }
    }

}
