<?php
App::uses('AppModel', 'Model');
/**
 * FactSummedVerbRuleDatetime Model
 *
 * @property System $System
 * @property Group $Group
 * @property User $User
 * @property Rule $Rule
 * @property Condition $Condition
 * @property DimensionDate $DimensionDate
 * @property DimensionTime $DimensionTime
 */
class FactSummedVerbRuleDatetime extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fact_summed_verb_rule_datetime';
	
	public $actsAs = array('Containable', 'Academicperiod', 'chartData');

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
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'rule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Condition' => array(
			'className' => 'Condition',
			'foreignKey' => 'condition_id',
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
	function getVerbRuleCount($dateWindow, $rule, $filter, $interval, $dateFormat) {
		$interval = new DateInterval($interval);
		$begin = new DateTime(date('Y-08-01', strtotime($dateWindow)));
		$end = new DateTime( date('Y-m-d',time()));
		$daterange = new DatePeriod($begin, $interval, $end);
	
		$data = array();
		foreach ($daterange as $date) {
			//In a leap year this creates an irreconcilable offset so skip this day
			if($date->format("d-M") != '29-Feb') {
				$conditions = array('rule_id' => $rule);
				$conditions = array_merge($conditions,array('DimensionDate.date >='=>$date->format("Y-m-d")));
				$date->add($interval);
				$conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
				$conditions = array_merge($conditions,$filter);
				//Iterate through rule condition to get count of each condition
				$rule_conditions = $this->Condition->get_rule_conditions($rule);
				foreach ($rule_conditions[0]['Condition'] as $rule_condition) {
					$conditions = array_merge($conditions, array('condition_id' => $rule_condition['id']));
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
							'fields' => "SUM(FactSummedVerbRuleDatetime.total) as total", //array of field names
					)
					);
					if($value[0]['total']) {
						$count = $value[0]['total'];
					}else{
						$count = 0;
					}
					$data[$rule_condition['name']][] = array((string)$date->format($dateFormat) => $count);
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
	function getVerbRuleCountGchart($dateWindow, $rule, $filter, $interval, $dateFormat) {
		$results = $this->getVerbRuleCount($dateWindow, $rule, $filter, $interval, $dateFormat);
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
	function getRulePieCount($dateWindow, $rule, $filter) {
		$start = strtotime($dateWindow);
	
		$data = array();
		
		$conditions = array('rule_id' => $rule);
		$conditions = array_merge($conditions,array('DimensionDate.date >='=>date("Y-m-d", $start)));
		$conditions = array_merge($conditions,$filter);
		
		//Iterate through rule condition to get count of each condition
		$rule_conditions = $this->Condition->get_rule_conditions($rule);

		foreach ($rule_conditions[0]['Condition'] as $rule_condition) {
			$conditions = array_merge($conditions, array('condition_id' => $rule_condition['id']));
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
						'fields' => "SUM(FactSummedVerbRuleDatetime.total) as total", //array of field names
					)
				);
			if($value[0]['total']) {
				$count = $value[0]['total'];
			}else{
				$count = 0;
			}
			$data[$rule][] = array($rule_condition['name'] => $count);
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
	function getRulePieChart($dateWindow, $rule, $filter) {
		$results = $this->getRulePieCount($dateWindow, $rule, $filter);
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
	function getIPRuleCount($dateWindow, $rule, $filter, $interval, $dateFormat) {
		$interval = new DateInterval($interval);
		$begin = new DateTime(date('Y-08-01', strtotime($dateWindow)));
		$end = new DateTime( date('Y-m-d',time()));
		$daterange = new DatePeriod($begin, $interval, $end);
	
		$data = array();
		foreach ($daterange as $date) {
			//In a leap year this creates an irreconcilable offset so skip this day
			if($date->format("d-M") != '29-Feb') {
				$conditions = array('rule_id' => $rule);
				$conditions = array_merge($conditions,array('DimensionDate.date >='=>$date->format("Y-m-d")));
				$date->add($interval);
				$conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
				$conditions = array_merge($conditions,$filter);
				//Iterate through rule condition to get count of each condition
				$rule_conditions = $this->Condition->get_rule_conditions($rule);
				$zero_condition = array_merge($conditions, array('condition_id' => 0));
				foreach ($rule_conditions[0]['Condition'] as $rule_condition) {
					$conditions = array_merge($conditions, array('condition_id' => $rule_condition['id']));
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
							'fields' => "SUM(FactSummedVerbRuleDatetime.total) as total", //array of field names
					)
					);
					if($value[0]['total']) {
						$count = $value[0]['total'];
					}else{
						$count = 0;
					}
					$data[$rule_condition['name']][] = array((string)$date->format($dateFormat) => $count);
				}
				//Creates the other record for IP address with zero condition
				$value = $this->find('first', array(
						'conditions' => $zero_condition, //array of conditions
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
						'fields' => "SUM(FactSummedVerbRuleDatetime.total) as total",
						) //array of field names
				);
				if($value[0]['total']) {
					$count = $value[0]['total'];
				}else{
					$count = 0;
				}
				$data['Other'][] = array((string)$date->format($dateFormat) => $count);
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
	function getIPRuleCountGchart($dateWindow, $rule, $filter, $interval, $dateFormat) {
		$results = $this->getIPRuleCount($dateWindow, $rule, $filter, $interval, $dateFormat);
		$data = $this->transformGchartArray($results);
		return $data;
	}
}
