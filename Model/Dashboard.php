<?php
App::uses('AppModel', 'Model');
/**
 * Dashboard Model
 *
 * @property Customer $Customer
 */
class Dashboard extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    /**
     * hasAndBelongsTo associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Report' => array(
            'className' => 'Report',
            'joinTable' => 'dashboard_reports',
            'foreignKey' => 'dashboard_id',
            'associationForeignKey' => 'report_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
    );

    /*
     * Get list of available customer dashboards.
     */
    public function getCustomerDashboard($customer_id) {
        return $this->find('list', array(
            'conditions' => array('customer_id' => $customer_id)
        ));
    }
}
