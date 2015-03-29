<?php
App::uses('AppModel', 'Model');
/**
 * ReportValue Model
 *
 * @property Report $Report
 * @property Value $Value
 */
class ReportValue extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Report' => array(
			'className' => 'Report',
			'foreignKey' => 'report_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Value' => array(
			'className' => 'Value',
			'foreignKey' => 'value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
