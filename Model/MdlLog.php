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

/**
 * Returns the date when logs were first recorded
 *
 * @return  string  timestamp of first log
 */
    public function getStart() {
        //$result = Cache::read('logstart', 'long');
        //if (!$result) {
            $result = $this->find('first', array(
                'fields' => "MIN(time) AS start", //array of field names
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
    function getPeriodCount($fields, $interval, $format) {
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
    function getPeriodCountGchart($fields, $interval, $format) {
        $results = $this->getPeriodCount($fields, $interval, $format);
        $data = $this->transformGchartArray($results);
        return $data;
    }

}
