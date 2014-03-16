<?php
App::uses('AppModel', 'Model');
/**
 * DashboardReport Model
 *
 * @property Report $Report
 * @property Dimension $Dimension
 */
class DashboardReport extends AppModel {


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
		'Dashboard' => array(
			'className' => 'Dashboard',
			'foreignKey' => 'dashboard_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
