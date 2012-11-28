<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class ActionByUserHour extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action_by_user_hour';
    var $cacheQueries = true;

    public $dateFormat = 'Y-m-d H:00:00';

    private $dayHours = array(13,14,15,16,17,18,19,8,9,10,11,12);
    private $nightHours = array(1,2,3,4,5,6,7,20,21,22,23,0);

    public function getHourStats($period, $report, $filter) {

        switch($period) {
            case 'day':
                $hours = $this->dayHours;
                break;
            case 'night':
                $hours = $this->nightHours;
                break;
        }

        switch($report) {
            case 'sum':
                $fields = "SUM(ActionByUserHour.total) as total";
                break;
            case 'avg':
                $fields = "AVG(ActionByUserHour.total) as total";
                break;
            case 'min':
                $fields = "MIN(ActionByUserHour.total) as total";
                break;
            case 'max':
                $fields = "MAX(ActionByUserHour.total) as total";
                break;
        }

        $data =array();
        foreach ($hours as $hour) {
            $conditions = array('hour'=>$hour);
            $conditions = array_merge($conditions,$filter);
            //$cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$date->format($periodFormat);
            //$value = Cache::read($cacheName, 'long');
            //if (!$value) {
            $value = $this->find('first', array(
                    'conditions' => $conditions, //array of conditions
                    'recursive' => -1, //int
                    'fields' => $fields, //array of field names
                )
            );
            //Cache::write($cacheName, $value, 'long');
            //}
            if($value[0]['total']) {
                $count = $value[0]['total'];
            }else{
                $count = 0;
            }

            $data[] = $count;
        }
        return $data;
    }

}
