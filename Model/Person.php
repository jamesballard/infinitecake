<?php
App::uses('AppModel', 'Model');
/**
 * Person Model
 *
 * @property Customer $Customer
 * @property Position $Position
 * @property Rule $Rule
 * @property User $User
 */
class Person extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'persons';

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'idnumber';

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
		),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'person_id',
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
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Course' => array(
            'className' => 'Course',
            'joinTable' => 'person_courses',
            'foreignKey' => 'person_id',
            'associationForeignKey' => 'course_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    /*
     * Get the sub list of dimension options when this model is used.
     *
     * @return array a list formatted array
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
     * Returns a filtered list of axis points for visualisations.
     *
     * @param $report
     * @return array|mixed
     */
    public function getAxisPoints($report) {
        $conditions = array(
            'Person.customer_id' => $report['Report']['customer_id']
        );

        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out courses.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Person') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_persons.'.$this->formatCacheConditions($conditions);
        $persons = Cache::read($cacheName, 'short');
        if (!$persons) {
            $persons = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, 'short');
        }
        return $persons;
    }
}
