<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 27/10/12
 * Time: 20:50
 */
class StatsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session', 'GChart.GChart');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('MdlLog');

    public function index() {

        //Set defaults

        $period = 'month';
        $chartType = 'area';
        $reportType = 'Activity';
        $width = 750;
        $height = 500;

        //Overwrite defaults if form submitted.
        if ($this->request->is('post')) {
            $period = $this->request->data['MdlLog']['period'];
            $chartType = $this->request->data['MdlLog']['chart'];
            $reportType = $this->request->data['MdlLog']['report'];
            $width = $this->request->data['MdlLog']['width'];
            $height = $this->request->data['MdlLog']['height'];
        }

        $data = array(
            'title' => $reportType,
            'type' => $chartType,
            'width' => $width,
            'height' => $height
        );
        $results = $this->getData($period, $reportType);
        $data = array_merge($data,$results);

        $this->set('data', $data);
    }

    /**
     * Contructs and returns appropriate data.
     *
     * @param integer $period Determines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getData($period, $reportType) {

        switch ($reportType) {
            case 'Activity':
                $fields = array();
                break;
            case 'Users':
                $fields = 'DISTINCT MdlLog.userid';
                break;
            case 'Courses':
                $fields = 'DISTINCT MdlLog.course';
                break;
        }

        switch ($period) {
            case 'day':
                $interval = new DateInterval('P1D');
                $periodFormat = "d-M";
                $data['labels'][] = array('string' => 'Day');
                break;
            case 'week':
                $interval = new DateInterval('P1W');
                $periodFormat = "W";
                $data['labels'][] = array('string' => 'Week');
                break;
            case 'month':
                $interval = new DateInterval('P1M');
                $periodFormat = "M";
                $data['labels'][] = array('string' => 'Month');
                break;
        }

        $data = $this->MdlLog->getPeriodCountGchart($fields, $interval, $periodFormat);
        return $data;
    }

}

