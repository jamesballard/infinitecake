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
    var $uses = array('Action', 'FactUserActionsDate', 'FactUserActionsTime');

    public function index() {
        $this->set('user','207');
        $this->Session->write('Profile.user', '207');
    }

    public function overview() {
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

    public function location() {

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

        $userid = $this->Session->read('Profile.user');

        $dayData = $this->FactUserActionsTime->getHourStats('day', $report, array('user_id'=>$userid));
        $dayData = base64_encode(serialize($dayData));

        $this->set('dayData', $dayData);

        $nightData = $this->FactUserActionsTime->getHourStats('night', $report, array('user_id'=>$userid));
        $nightData = base64_encode(serialize($nightData));

        $this->set('nightData', $nightData);

    }

    public function modules() {
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

    private function getOverviewData($period) {
        $userid = $this->Session->read('Profile.user');

        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M";
                $data = $this->FactUserActionsDate->getPeriodCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
            break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W';
                $data = $this->FactUserActionsDate->getPeriodCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
            break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M";
                $data = $this->FactUserActionsDate->getPeriodCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
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
        $data = $this->FactUserActionsDate->getModuleCountTreemap(array('user_id'=>$userid));
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
                $dateFormat = "d-M";
                $data = $this->FactUserActionsDate->getTaskTypeCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W';
                $data = $this->FactUserActionsDate->getTaskTypeCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M";
                $data = $this->FactUserActionsDate->getTaskTypeCountGchart(array('user_id'=>$userid), $interval, $dateFormat);
                return $data;
                break;
        }
    }

}
