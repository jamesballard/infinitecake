<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 28/10/12
 * Time: 19:20
 */
App::uses('File', 'Utility');

class CourseprofileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'autoComplete.autoCompleteRemote');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'Group', 'FactSummedActionsDatetime', 'FactUserVerbRuleDatetime');

    public function index() {
     //Create selected group as session variable.            
        $groupid = $this->Session->read('Profile.group');
        if ($this->request->is('post')) {
            $group = $this->request->data['Action']['groupid'];
            $this->set('groupid', $group);
            $this->set('groupdefault', $group);
            $this->Session->write('Profile.group', $group);
        }elseif($groupid){
        	$selectedgroup = $this->Group->find('first',array(
	        			'conditions' => array('id'=>$groupid), //array of conditions
	        			'recursive' => -1, //int
	        			'fields' => array('idnumber'), //array of field names
	        		)
        	);
        	$this->set('groupid', $groupid);
            $this->set('groupdefault', $selectedgroup['Group']['idnumber']);
        }else{
        	$this->set('groupid','');
            $this->set('groupdefault','');
        }
    }

    public function overview() {
    	$groupid = $this->Session->read('Profile.group');
    	if(!$groupid) {
    		$this->Session->setFlash(__('No group selected'));
    		$this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
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

    public function hourly() {
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

        $groupid = $this->Session->read('Profile.course');

        $dayData = $this->ActionByUserHour->getHourStats('day', $report, array('group'=>$groupid));
        $dayData = base64_encode(serialize($dayData));

        $this->set('dayData', $dayData);

        $nightData = $this->ActionByUserHour->getHourStats('night', $report, array('group'=>$groupid));
        $nightData = base64_encode(serialize($nightData));

        $this->set('nightData', $nightData);

    }

    public function location() {

    }

    public function modules() {
        //Set defaults
        $reportType = 'Activity';
        $width = 750;
        $height = 500;

        //Overwrite defaults if form submitted.
        if ($this->request->is('post')) {
            $reportType = $this->request->data['Action']['report'];
            $width = $this->request->data['Action']['width'];
            $height = $this->request->data['Action']['height'];
        }

        $this->set('width', $width);
        $this->set('height', $height);
        $this->set('data', $this->getModuleData());
    }

    public function tasktype() {
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
        if($chartType = ('bar' || 'column')) {
            $data['isStacked'] = true;
        }
        $results = $this->getTaskTypeData($period);
        $data = array_merge($data,$results);

        $this->set('data', $data);

    }

        /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getOverviewData($period, $system) {
        $groupid = $this->Session->read('Profile.group');

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

        $group_ids = $this->Group->find('list', array(
                'conditions' => array('id' => $groupid), //array of conditions
                'recursive' => -1, //int
                'fields' => array('Group.id'), //array of field names
            )
        );

        $conditions = array('group_id'=>$group_ids);
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
        $groupid = $this->Session->read('Profile.group');
        $group_ids = $this->Group->find('list', array(
                'conditions' => array('group_id' => $groupid), //array of conditions
                'recursive' => -1, //int
                'fields' => array('Group.id'), //array of field names
            )
        );

        $conditions = array('group_id'=>$group_ids);
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
        $groupid = $this->Session->read('Profile.group');

        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M-y";
                $data = $this->FactSummedActionsDatetime->getVerbRuleCountGchart(1,array('group_id'=>$groupid), $interval, $dateFormat);
                return $data;
                break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W-o';
                $data = $this->FactSummedActionsDatetime->getVerbRuleCountGchart(1,array('group_id'=>$groupid), $interval, $dateFormat);
                return $data;
                break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M-y";
                $data = $this->FactSummedActionsDatetime->getVerbRuleCountGchart(1,array('group_id'=>$groupid), $interval, $dateFormat);
                return $data;
                break;
        }
    }
}



