<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 21:37
 */
class UserprofileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'User', 'FactSummedActionsDate', 'FactSummedActionsDatetime', 'FactUserVerbRuleDate');

    public function index() {
        //Create selected user as session variable.
        if ($this->request->is('post')) {
            $user = $this->request->data['Action']['user'];
            $this->set('user',$user);
            $this->Session->write('Profile.user', $user);
        }elseif($userid = $this->Session->read('Profile.user')){
            $this->set('user', $userid);
        }else{
            $this->set('user','');
        }
        $users = $this->User->find('list');
		$this->set(compact('users'));
    }

    public function overview() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'userprofile', 'action' => ''));
        }else{
            //Set defaults
            $period = 'month';
            $chartType = 'area';
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
            $results = $this->getOverviewData($period);
            $data = array_merge($data,$results);

            $this->set('data', $data);
        }
    }

    public function location() {

    }

    public function hourly() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'userprofile', 'action' => ''));
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
            $this->redirect(array('controller' => 'userprofile', 'action' => ''));
        }else{
            //Set defaults
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $reportType = $this->request->data['MdlUser']['report'];
                $width = $this->request->data['MdlUser']['width'];
                $height = $this->request->data['MdlUser']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            $this->set('data', $this->getModuleData($reportType));
        }
    }

    public function tasktype() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'userprofile', 'action' => ''));
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
            if($chartType = ('bar' || 'column')) {
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

    private function getOverviewData($period) {
        $userid = $this->Session->read('Profile.user');

        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M";
                $data = $this->FactSummedActionsDatetime->getPeriodCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
            break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W';
                $data = $this->FactSummedActionsDatetime->getPeriodCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
            break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M";
                $data = $this->FactSummedActionsDatetime->getPeriodCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
            break;
        }
    }

    /**
     * Contructs and returns module treemap data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getModuleData() {
        $userid = $this->Session->read('Profile.user');
        $data = $this->FactSummedActionsDatetime->getModuleCountTreemap(array('user_id'=>$userid));
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
                $data = $this->FactSummedActionsDatetime->getVerbRuleCountGchart(1,array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W-o';
                $data = $this->FactSummedActionsDatetime->getVerbRuleCountGchart(1,array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M-y";
                $data = $this->FactSummedActionsDatetime->getVerbRuleCountGchart(1,array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
        }
    }

}
