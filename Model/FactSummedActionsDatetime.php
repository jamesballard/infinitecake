<?php
App::uses('AppModel', 'Model');
/**
 * FactSummedActionsDatetime Model
 *
 * @property System $System
 * @property Group $Group
 * @property User $User
 * @property Artefact $Artefact
 * @property DimensionDate $DimensionDate
 * @property DimensionTime $DimensionTime
 */
class FactSummedActionsDatetime extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fact_summed_actions_datetime';

    public $actsAs = array('Academicperiod', 'chartData');

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'system_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'total';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'System' => array(
			'className' => 'System',
			'foreignKey' => 'system_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
		'DimensionDate' => array(
			'className' => 'DimensionDate',
			'foreignKey' => 'dimension_date_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DimensionTime' => array(
			'className' => 'DimensionTime',
			'foreignKey' => 'dimension_time_id',
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
    function getPeriodCount($dateWindow, $filter, $interval, $dateFormat) {
        $interval = new DateInterval($interval);
        $start = strtotime($dateWindow);
        $daterange = $this->getAcademicPeriod($start, $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format("d-M") != '29-Feb') {
                    $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                    $date->add($interval);
                    $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                    $conditions = array_merge($conditions,$filter);
                    $cacheName = 'period_count.'.$this->formatCacheConditions($conditions);
                    $value = Cache::read($cacheName, 'long');
                    if (!$value) {
                        $value = $this->find('first', array(
                                'conditions' => $conditions, //array of conditions
                                'contain' => array(
                                    'DimensionDate' => array(
                                        'fields' => array(
                                            'DimensionDate.date'
                                        )
                                    ),
                                    'System' => array(
                                        'fields' => array(
                                            'System.id'
                                        )
                                    )
                                ),
                                'fields' => "SUM(FactSummedActionsDatetime.total) as total", //array of field names
                            )
                        );
                        Cache::write($cacheName, $value, 'long');
                    }
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
    function getPeriodCountGchart($dateWindow, $filter, $interval, $dateFormat) {
        $results = $this->getPeriodCount($dateWindow, $filter, $interval, $dateFormat);
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
    function getModuleCount($dateWindow, $filter) {
        $start = strtotime($dateWindow);
        $interval = new DateInterval('P1Y');
        $daterange = $this->getAcademicPeriod($start, $interval);

        $data = array();
        $artefacts = $this->Artefact->getArtefacts();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                $date->add($interval);
                $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                $conditions = array_merge($conditions,$filter);
                $date->sub($interval);
                //Iterate through modules to get count of each per category
                foreach ($artefacts as $artefact) {
                    $conditions = array_merge($conditions, array('FactSummedActionsDatetime.artefact_id' => $artefact['Artefact']['id']));
                    $cacheName = 'module_count.'.$this->formatCacheConditions($conditions);
                    $value = Cache::read($cacheName, 'long');
                    if (!$value) {
                        $value = $this->find('first', array(
                                'conditions' => $conditions, //array of conditions
                                'contain' => array(
                                    'DimensionDate' => array(
                                        'fields' => array(
                                            'DimensionDate.date'
                                        )
                                    ),
                                    'Artefact' => array(
                                        'fields' => array(
                                            'Artefact.name'
                                        )
                                    ),
                                    'System' => array(
                                        'fields' => array(
                                            'System.id'
                                        )
                                    )
                                ),
                                'fields' => "SUM(FactSummedActionsDatetime.total) as total", //array of field names
                            )
                        );
                        Cache::write($cacheName, $value, 'long');
                    }
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

    function getModuleCountTreemap($dateWindow, $filter) {
        $results = $this->getModuleCount($dateWindow, $filter);
        $data = $this->transformModuleTreemap($results);
        return $data;
    }

    private $dayHours = array(13,14,15,16,17,18,19,8,9,10,11,12);
    private $nightHours = array(1,2,3,4,5,6,7,20,21,22,23,0);

    public function getHourStats($dateWindow, $period, $report, $filter) {
    	$start = strtotime($dateWindow);

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
                $fields = "SUM(FactSummedActionsDatetime.total) as total";
                break;
            case 'avg':
                $fields = "AVG(FactSummedActionsDatetime.total) as total";
                break;
            case 'min':
                $fields = "MIN(FactSummedActionsDatetime.total) as total";
                break;
            case 'max':
                $fields = "MAX(FactSummedActionsDatetime.total) as total";
                break;
        }

        $data =array();
        $conditions = array('DimensionDate.date >='=>date("Y-m-d", $start));
        foreach ($hours as $hour) {
            $conditions = array_merge($conditions,array('DimensionTime.hour'=>$hour));
            $conditions = array_merge($conditions,$filter);
            $cacheName = 'hour_stats.'.$this->formatCacheConditions($conditions);
            $value = Cache::read($cacheName, 'long');
            if (!$value) {
                $value = $this->find('first', array(
                        'conditions' => $conditions, //array of conditions
                        'contain' => array(
                            'DimensionTime' => array(
                                'fields' => array(
                                    'DimensionTime.hour'
                                )
                            ),
                            'DimensionDate' => array(
                                'fields' => array(
                                    'DimensionDate.date'
                                )
                            ),
                            'System' => array(
                                'fields' => array(
                                    'System.id'
                                )
                            )
                        ),
                        'fields' => $fields, //array of field names
                    )
                );
                Cache::write($cacheName, $value, 'long');
            }
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
