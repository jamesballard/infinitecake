<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class ActionByUserDay extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action_by_user_day';
    var $cacheQueries = true;

    public $dateFormat = 'Y-m-d';

    public $actsAs = array('Academicperiod', 'Gchart');

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getPeriodCount($filter) {
        $interval = new DateInterval('P1D');
        $start = $this->getStart($filter);
        $daterange = $this->getAcademicPeriod($start[0]['start'], $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format("d-M") != '29-Feb') {
                    $conditions = array('time'=>strtotime($date->format("Y-m-d")));
                    $conditions = array_merge($conditions,$filter);
                    //$cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$date->format($periodFormat);
                    //$value = Cache::read($cacheName, 'long');
                    //if (!$value) {
                    $value = $this->find('first', array(
                            'conditions' => $conditions, //array of conditions
                            'recursive' => -1, //int
                            'fields' => "SUM(ActionByUserDay.total) as total", //array of field names
                        )
                    );
                    //Cache::write($cacheName, $value, 'long');
                    //}
                    if($value[0]['total']) {
                        $count = $value[0]['total'];
                    }else{
                        $count = 0;
                    }

                    $data[$year][] = array((string)$date->format("d-M") => $count);
                }
            }
        }
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available in GChart format
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getPeriodCountGchart($filter) {
        $results = $this->getPeriodCount($filter);
        $data = $this->transformGchartArray($results);
        return $data;
    }

}
