<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 21:37
 */
class UserprofileController extends AppController {
    public $helpers = array('Html', 'Form', 'Session', 'GChart.GChart', 'DrasticTreeMap.DrasticTreeMap');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('MdlUser', 'MdlLog');

    public function index() {
        $this->set('user',$this->MdlUser->getUser('37953'));
        $this->Session->write('Profile.user', '39756');
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
            $period = $this->request->data['MdlUser']['period'];
            $chartType = $this->request->data['MdlUser']['chart'];
            $reportType = $this->request->data['MdlUser']['report'];
            $width = $this->request->data['MdlUser']['width'];
            $height = $this->request->data['MdlUser']['height'];
        }

        $data = array(
            'title' => $reportType,
            'type' => $chartType,
            'width' => $width,
            'height' => $height
        );
        $results = $this->getOverviewData($period, $reportType);
        $data = array_merge($data,$results);

        $this->set('data', $data);
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
            $reportType = $this->request->data['MdlUser']['report'];
            $width = $this->request->data['MdlUser']['width'];
            $height = $this->request->data['MdlUser']['height'];
        }

        $this->set('width', $width);
        $this->set('height', $height);
        $this->set('data', $this->getModuleData($reportType));
    }

    public function tasktype() {

    }

    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getOverviewData($period, $reportType) {
        $userid = $this->Session->read('Profile.user');
        $data = $this->MdlLog->getPeriodCountGchart($period, $reportType, array('userid'=>$userid));
        return $data;
    }

    /**
     * Contructs and returns module treemap data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getModuleData($reportType) {
        $userid = $this->Session->read('Profile.user');
        $data = $this->MdlLog->getModuleCountTreemap($reportType, array('userid'=>$userid));
        return $data;
    }

}
