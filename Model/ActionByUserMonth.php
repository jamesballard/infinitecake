<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class ActionByUserMonth extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action_by_user_month';
    var $cacheQueries = true;

    public $dateFormat = 'Y-m-01';

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
        $interval = new DateInterval('P1M');
        $start = $this->getStart($filter);
        $daterange = $this->getAcademicPeriod($start[0]['start'], $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                $conditions = array('time'=>strtotime($date->format("Y-m-01")));
                $conditions = array_merge($conditions,$filter);
                //$cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$date->format($periodFormat);
                //$value = Cache::read($cacheName, 'long');
                //if (!$value) {
                $value = $this->find('first', array(
                        'conditions' => $conditions, //array of conditions
                        'recursive' => -1, //int
                        'fields' => "SUM(ActionByUserMonth.total) as total", //array of field names
                    )
                );
                //Cache::write($cacheName, $value, 'long');
                //}
                if($value[0]['total']) {
                    $count = $value[0]['total'];
                }else{
                    $count = 0;
                }

                $data[$year][] = array((string)$date->format("M") => $count);
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

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getModuleCount($filter) {
        $start = $this->getStart($filter);
        $interval = new DateInterval('P1Y');
        $daterange = $this->getAcademicPeriod($start[0]['start'], $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                $conditions = array('time > '=>strtotime($date->format("Y-m-d H:i:s")));
                $date->add($interval);
                $conditions = array_merge($conditions,array('time < '=>strtotime($date->format("Y-m-d H:i:s"))));
                $conditions = array_merge($conditions,$filter);
                $date->sub($interval);
                //Iterate through modules to get count of each per category
                foreach ($this->getModules() as $module=>$type) {
                    $conditions = array_merge($conditions, array('module' => $module));
                    $value = $this->find('first', array(
                            'conditions' => $conditions, //array of conditions
                            'recursive' => -1, //int
                            'fields' => "SUM(ActionByUserMonth.total) as total", //array of field names
                        )
                    );
                    if($value[0]['total']) {
                        $count = $value[0]['total'];
                    }else{
                        $count = 0;
                    }
                    $data[$year][] = array($module => $count);
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

    function getModuleCountTreemap($filter) {
        $results = $this->getModuleCount($filter);
        $data = $this->transformModuleTreemap($results);
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getTaskTypeCount($filter) {
        $interval = new DateInterval('P1M');
        $start = $this->getStart($filter);
        $begin = new DateTime(date('Y-08-01', strtotime("-1 year")));
        $end = new DateTime( date('Y-m-d',time()));
        $daterange = new DatePeriod($begin, $interval, $end);

        $data = array();
        foreach ($daterange as $date) {
                $conditions = array('time'=>strtotime($date->format("Y-m-01")));
                $conditions = array_merge($conditions,$filter);
                //Iterate through modules to get count of each per category
                foreach ($this->getTaskTypes() as $functionName=>$task) {
                    switch($functionName) {
                        case 'assimilative':
                            $conditions = array_merge($conditions, array('action' => $this->assimilativeActions()));
                            break;
                        case 'information':
                            $conditions = array_merge($conditions, array('action' => $this->informationActions()));
                            break;
                        case 'adaptive':
                            $conditions = array_merge($conditions, array('action' => $this->adaptiveActions()));
                            break;
                        case 'communicative':
                            $conditions = array_merge($conditions, array('action' => $this->communicativeActions()));
                            break;
                        case 'productive':
                            $conditions = array_merge($conditions, array('action' => $this->productiveActions()));
                            break;
                        case 'experiential':
                            $conditions = array_merge($conditions, array('action' => $this->experientialActions()));
                            break;
                    }

                    $value = $this->find('first', array(
                            'conditions' => $conditions, //array of conditions
                            'recursive' => -1, //int
                            'fields' => "SUM(ActionByUserMonth.total) as total", //array of field names
                        )
                    );
                    if($value[0]['total']) {
                        $count = $value[0]['total'];
                    }else{
                        $count = 0;
                    }
                    $data[$task][] = array((string)$date->format("M-y") => $count);
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
    function getTaskTypeCountGchart($filter) {
        $results = $this->getTaskTypeCount($filter);
        $data = $this->transformGchartArray($results);
        return $data;
    }

}
