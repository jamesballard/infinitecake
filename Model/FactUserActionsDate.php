<?php
App::uses('AppModel', 'Model');
/**
 * FactUserActionsDate Model
 *
 * @property User $User
 * @property Artefact $Artefact
 * @property DimensionVerb $DimensionVerb
 * @property DimensionDate $DimensionDate
 */
class FactUserActionsDate extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fact_user_actions_date';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'total';

    public $actsAs = array('Academicperiod', 'Gchart');

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Artefact' => array(
			'className' => 'Artefact',
			'foreignKey' => 'artefact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DimensionVerb' => array(
			'className' => 'DimensionVerb',
			'foreignKey' => 'dimension_verb_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DimensionDate' => array(
			'className' => 'DimensionDate',
			'foreignKey' => 'dimension_date_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getPeriodCount($filter, $interval, $dateFormat) {
        $interval = new DateInterval($interval);
        $start = $this->getStart($filter);
        $daterange = $this->getAcademicPeriod($start[0]['start'], $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format("d-M") != '29-Feb') {
                    $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                    $date->add($interval);
                    $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                    $conditions = array_merge($conditions,$filter);
                    //$cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$date->format($periodFormat);
                    //$value = Cache::read($cacheName, 'long');
                    //if (!$value) {
                    $value = $this->find('first', array(
                            'conditions' => $conditions, //array of conditions
                            'recursive' => 0, //int
                            'fields' => "SUM(FactUserActionsDate.total) as total", //array of field names
                        )
                    );
                    //Cache::write($cacheName, $value, 'long');
                    //}
                    if($value[0]['total']) {
                        $count = $value[0]['total'];
                    }else{
                        $count = 0;
                    }
                    $date->sub($interval);
                    $data[$year][] = array((string)$date->format($dateFormat) => $count);
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
    function getPeriodCountGchart($filter, $interval, $dateFormat) {
        $results = $this->getPeriodCount($filter, $interval, $dateFormat);
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
                $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                $date->add($interval);
                $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                $conditions = array_merge($conditions,$filter);
                $date->sub($interval);
                //Iterate through modules to get count of each per category
                foreach ($this->Artefact->getArtefacts() as $artefact) {
                    $conditions = array_merge($conditions, array('FactUserActionsDate.artefact_id' => $artefact['Artefact']['id']));
                    $value = $this->find('first', array(
                            'conditions' => $conditions, //array of conditions
                            'recursive' => 0, //int
                            'fields' => "SUM(FactUserActionsDate.total) as total", //array of field names
                        )
                    );
                    if($value[0]['total']) {
                        $count = $value[0]['total'];
                    }else{
                        $count = 0;
                    }
                    $data[$year][] = array($artefact['Artefact']['name'] => $count);
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

}
