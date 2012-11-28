<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 27/10/12
 * Time: 20:50
 */
class StatsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session', 'GChart.GChart', 'DrasticTreeMap.DrasticTreeMap');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'ActionByUserDay', 'ActionByUserWeek', 'ActionByUserMonth');

    public function index() {

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

    public function modules() {
        //Set defaults
        $reportType = 'Activity';
        $width = 750;
        $height = 500;

        //Overwrite defaults if form submitted.
        if ($this->request->is('post')) {
            $reportType = $this->request->data['MdlLog']['report'];
            $width = $this->request->data['MdlLog']['width'];
            $height = $this->request->data['MdlLog']['height'];
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

    private function getOverviewData($period) {
        $courseid = $this->Session->read('Profile.course');

        switch($period) {
            case 'day':
                $data = $this->ActionByUserDay->getPeriodCountGchart(array());
                return $data;
                break;
            case 'week':
                $data = $this->ActionByUserWeek->getPeriodCountGchart(array());
                return $data;
                break;
            case 'month':
                $data = $this->ActionByUserMonth->getPeriodCountGchart(array());
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
        $data = $this->ActionByUserMonth->getModuleCountTreemap(array());
        return $data;
    }

}

