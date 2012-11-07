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


        //Get relevant configuration from forms.
        if ($this->request->is('post')) {
            $period = $this->request->data['MdlLog']['period'];
            $chartType = $this->request->data['MdlLog']['chart'];
            $reportType = $this->request->data['MdlLog']['report'];
            $width = $this->request->data['MdlLog']['width'];
            $height = $this->request->data['MdlLog']['height'];
            $this->get_data($chartType,$period,$reportType,$width,$height);
        } else {
            $this->get_data();
        }



    }

    private function get_start() {
        $params = array(
            //'conditions' => false, //array of conditions
            'recursive' => 0, //int
            'fields' => "MIN(time) AS start", //array of field names
            //'order' => n, //string or array defining order
            //'group' =>$group, //fields to GROUP BY
            //'limit' => n, //int
            //'page' => n, //int
            //'offset' => n, //int
            'callbacks' => true //other possible values are false, 'before', 'after'
        );
        $result = Cache::read('logstart', 'long');
        if (!$result) {
            $result = $this->MdlLog->find('first',$params);
            Cache::write('logstart', $result, 'long');
        }
        return $result;
    }

    /**
     * Contructs and returns appropriate data.
     *
     * @period integer Determines how data will be grouped 0 for none; 1 for month, 2 for day
     */

    private function get_data($chartType='line', $period='month', $reportType='activity',$width=750,$height=500) {

        switch ($reportType) {
            case 'activity':
                $title = 'Activity';
                $fields = array();
                break;
            case 'users':
                $title = 'Unique Users';
                $fields = 'DISTINCT MdlLog.userid';
                break;
            case 'courses':
                $title = 'Unique Courses';
                $fields = 'DISTINCT MdlLog.course';
                break;
        }

        $data = array(
            'title' => $title,
            'type' => $chartType,
            'width' => $width,
            'height' => $height,
        );

        $startdate = $this->get_start();
        $begin = new DateTime(date('Y-m-01',$startdate[0]['start']));
        $end = new DateTime( date('Y-m-01',time()) );

        // Get academic years.
        $interval = new DateInterval('P1Y');
        $daterange = new DatePeriod($begin, $interval,$end);

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

        $i = 1;
        foreach ($daterange as $date) {
            $start = $date->format("Y");
            $data['labels'][] = array('number' => $this->get_academic_year_name($start));

            $begin = new DateTime($date->format("Y-08-01"));
            $date->modify( '+1 year' );
            $end = new DateTime($date->format("Y-08-01"));

            $xrange = new DatePeriod($begin, $interval, $end);

            $n = 0;
            foreach ($xrange as $x) {
                $conditions = array('time > '=>strtotime($x->format("Y-m-d H:i:s")));
                $x->modify( '+1 '.$period );
                $conditions = array_merge($conditions,array('time < '=>strtotime($x->format("Y-m-d H:i:s"))));
                $params = array(
                    'conditions' => $conditions, //array of conditions
                    'recursive' => 0, //int
                    'fields' => $fields, //array of field names
                    //'order' => n, //string or array defining order
                    //'group' =>$group, //fields to GROUP BY
                    //'limit' => n, //int
                    //'page' => n, //int
                    //'offset' => n, //int
                    'callbacks' => true //other possible values are false, 'before', 'after'
                );
                $cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$x->format($periodFormat);
                $value = Cache::read($cacheName, 'long');
                if (!$value) {
                    $value = $this->MdlLog->find('count',$params);
                    Cache::write($cacheName, $value, 'long');
                }
                $x->modify( '-1 '.$period );
                if($x->format($periodFormat) != '29-Feb') {
                    $data['data'][$n][0] = $x->format($periodFormat);
                    $data['data'][$n][$i] = $value;
                    $n++;
                }
            }
            $i++;
        }
        $this->set('data', $data);

    }

    private function get_academic_year_name($startyear) {
        $acYear = $startyear.'/'.substr(($startyear + 1),-2);
        return $acYear;
    }



}

