<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlLog extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'log';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $belongsTo = array(
        'User' => array(
            'className'    => 'MdlUser',
            'foreignKey'   => 'userid'
        ),
        'Course' => array(
            'className'    => 'MdlCourse',
            'foreignKey'   => 'course'
        )
    );

    public $actsAs = array('Academicperiod', 'Gchart');

    public $fields = array(
        'Activity' => array(),
        'Users' => 'DISTINCT MdlLog.userid',
        'Courses' => 'DISTINCT MdlLog.course'
    );

    public $dateformats = array(
        'day' => array(
            'interval' => 'P1D',
            'format' => "d-M"
        ),
        'week' => array (
            'interval' => 'P1W',
            'format' => "W"
        ),
        'month' => array(
            'interval' => 'P1M',
            'format' => "M"
        )
    );

/**
 * Returns the date when logs were first recorded
 *
 * @return  string  timestamp of first log
 */
    public function getStart($filter=false) {
        //$result = Cache::read('logstart', 'long');
        //if (!$result) {
        $conditions = array();
        if($filter) {
            $conditions = $filter;
        }
        $result = $this->find('first', array(
                'fields' => "MIN(time) AS start", //array of field names
                'conditions' => $conditions
            ));
            //Cache::write('logstart', $result, 'long');
        //}
        return $result;
    }

/**
 * Returns a Count for selected interval for the years available
 *
 * @param string $fields the fields intended to be counted
 * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
 * @param string $format date format (e.g. 'M')
 * @return array Academic Year => Period => Count
 */
    function getPeriodCount($fields, $interval, $format, $filter) {
        $start = $this->getStart();
        $daterange = $this->getAcademicPeriod($start[0]['start'], $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format($format) != '29-Feb') {
                    $conditions = array('time > '=>strtotime($date->format("Y-m-d H:i:s")));
                    $date->add($interval);
                    $conditions = array_merge($conditions,array('time < '=>strtotime($date->format("Y-m-d H:i:s"))));
                    $conditions = array_merge($conditions,$filter);
                    //$cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$date->format($periodFormat);
                    //$value = Cache::read($cacheName, 'long');
                    //if (!$value) {
                        $value = $this->find('count', array(
                                'conditions' => $conditions, //array of conditions
                                'recursive' => -1, //int
                                'fields' => $fields, //array of field names
                            )
                        );
                        //Cache::write($cacheName, $value, 'long');
                    //}

                    $date->sub($interval);
                    $data[$year][] = array((string)$date->format($format) => $value);
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
    function getPeriodCountGchart($period, $reportType, $filter) {
        $interval = new DateInterval($this->dateformats[$period]['interval']);
        $results = $this->getPeriodCount($this->fields[$reportType], $interval, $this->dateformats[$period]['format'], $filter);
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
    function getModuleCount($reportType, $filter) {
        $start = strtotime("-2 years", time());
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
                    $value = $this->find('count', array(
                            'conditions' => $conditions, //array of conditions
                            'recursive' => -1, //int
                        )
                    );

                    $data[$year][] = array($module => $value);
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

    function getModuleCountTreemap($reportType, $filter) {
        $results = $this->getModuleCount($reportType, $filter);
        $data = $this->transformModuleTreemap($results);
        return $data;
    }

}
