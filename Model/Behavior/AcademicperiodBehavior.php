<?php
App::uses('Action', 'Model');
/**
 * Academic Year behavior
 *
 * Returns date ranges allowing queries to be grouped by Academic Year
 *
 * @package       Cake.Model.Behavior
 * @link
 */
class AcademicperiodBehavior extends ModelBehavior {

/**
 * Returns the academic year in format YYYY/yy based on start year
 *
 * @param   integer $startYear  format YYYY
 * @return  string  $acYear     format YYYY/yy
 */
    function nameAcademicYear(Model $Model, $startYear) {
        $acYear = $startYear. '/'. substr(($startYear + 1),-2);
        return $acYear;
    }

    /**
     * Returns a DatePeriod for the years that logs are recorded to current date
     *
     * @param   timestamp   $start      Start date as timestamp, 0 = go back 1 year
     * @return  DatePeriod  $daterange  http://php.net/manual/en/class.dateperiod.php
     */
    function getYears(Model $Model, $start=0) {
        if($start > 0) {
            $yearStart = strtotime ( '-7 months' , $start ) ;
            $begin = new DateTime(date('Y-m-01', $yearStart));
        }else{
            $begin = new DateTime(date('Y-m-01',strtotime("-1 year", time())));
        }

        //Add 5 months to push into next academic year (e.g. August +5) = UK Academic Year
        $end = new DateTime( date('Y-m-01',strtotime("+5 months")));
        // Get years as range.
        $interval = new DateInterval('P1Y');
        $daterange = new DatePeriod($begin, $interval, $end);

        return $daterange;
    }

/**
 * Returns a DatePeriod for selected interval for the years available
 *
 * @param   Model/model.class $model The model using this behaviour
 * @param   timestamp      $start
 * @param   DateInterval    $interval http://php.net/manual/en/class.dateinterval.php
 * @return  array           Academic Year => DatePeriod
 */
    function getAcademicPeriod(Model $Model, $start, $interval='P1Y') {
        $daterange = $this->getYears($Model, $start);
        $periods = array();
        foreach ($daterange as $date) {
            $start = $date->format("Y");
            $academicYear = $this->nameAcademicYear($Model, $start);

            $begin = new DateTime($date->format("Y-08-01"));
            $date->modify( '+1 year' );
            $end = new DateTime($date->format("Y-08-01"));

            $xrange = new DatePeriod($begin, $interval, $end);
            $periods[$academicYear] = $xrange;
        }
        return $periods;
    }

}
