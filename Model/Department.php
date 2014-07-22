<?php
App::uses('AppModel', 'Model');
/**
 * Department Model
 *
 * @property Course $Course
 * @property Department $ChildDepartment
 */
class Department extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Model behaviour
 *
 * @var string
 */
    public $actsAs = array('Tree');

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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'department_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'department_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
	);

    /**
     * Returns an array of courses based on a customer id
     * @param int $customer_id - the id of a customer
     * @return array of artefacts
     */
    public function getCustomerDepartments($customer_id = null) {
        if(empty($customer_id)) return false;
        $conditions = array(
            'Department.customer_id' => $customer_id
        );
        $cacheName = 'customer_departments.'.$this->formatCacheConditions($conditions);
        $departments = Cache::read($cacheName, 'short');
        if (!$departments) {
            $departments = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, 'short');
        }
        return $departments;
    }

    /**
     * Get the sub list of dimension options when this model is used.
     *
     * @param $customer_id
     * @return array
     */
    public function getDimensionParameters($customer_id) {
        return array(0 => __('No option required'));
    }

    /**
     * Get the sub list of dimension options when this model is used.
     *
     * @param array|integer $customer_id
     * @return array a list formatted array
     */
    public function getFilterOptions($customer_id) {
        return $this->find('list', array(
            'conditions' => array('customer_id' => $customer_id)
        ));
    }

    /**
     * Returns record as labels for report.
     *
     * @param integer $id
     * @param mixed $report
     * @return array
     */
    public function getLabels($id, $report) {
        $labels = array();
        $departments = $this->getCustomerDepartments($report['Report']['customer_id']);
        foreach ($departments as $department) {
            $labels[] =array(
                'name' => $department['Department']['name'],
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'Artefact.id' => $department['Department']['id']
                ),
            );
        }
        return $labels;
    }

    /**
     * Returns a filtered list of axis points for visualisations.
     *
     * @param $report
     * @return array|mixed
     */
    public function getAxisPoints($report) {
        $conditions = array(
            'Department.customer_id' => $report['Report']['customer_id']
        );

        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out courses.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Department') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_departments.'.$this->formatCacheConditions($conditions);
        $departments = Cache::read($cacheName, 'short');
        if (!$departments) {
            $departments = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, 'short');
        }
        return $departments;
    }

}
