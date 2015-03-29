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

    /**
     * Count the number of courses for a given customer.
     *
     * @param $customer_id
     * @return array|mixed
     */
    public function countCustomerPeople($customer_id) {
        $conditions = array('Customer.id' => $customer_id);
        $cacheName = 'customer_persons_count.'.$this->formatCacheConditions($conditions);
        $people = Cache::read($cacheName, 'short');
        if (!$people) {
            $people = $this->find('count', array(
                    'contain' => false,
                    'joins' => array(
                        array(
                            'table' => 'customers',
                            'alias' => 'Customer',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Customer.id = Person.customer_id'
                            )
                        ),
                    ),
                    'conditions' => $conditions
                )
            );
            Cache::write($cacheName, $people, 'short');
        }
        return $people;
    }

    /**
     * Returns an array of people based on a customer id
     * @param int $customer_id - the id of a customer
     * @return array of people
     */
    public function getCustomerPeople($customer_id = null) {
        if(empty($customer_id)) return false;
        $conditions = array(
            'Person.customer_id' => $customer_id
        );
        $cacheName = 'customer_persons_all.'.$this->formatCacheConditions($conditions);
        $people = Cache::read($cacheName, 'short');
        if (!$people) {
            $people = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, $people, 'short');
        }
        return $people;
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
        $people = $this->getCustomerPeople($report['Report']['customer_id']);
        foreach ($people as $person) {
            $labels[] =array(
                'name' => $person['Person']['idnumber'],
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'Person.id' => $person['Person']['id']
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
            'Person.customer_id' => $report['Report']['customer_id']
        );

        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out courses.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Person') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_persons_axis.'.$this->formatCacheConditions($conditions);
        $persons = Cache::read($cacheName, 'short');
        if (!$persons) {
            $persons = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, $persons, 'short');
        }
        return $persons;
    }
}
