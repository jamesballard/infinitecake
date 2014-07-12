<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 * @property Department $Department
 * @property Person $Person
 */
class Course extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'idnumber';

    public $filtertype = 'select';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'course_id',
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
        'Condition' => array(
            'className' => 'Condition',
            'joinTable' => 'course_conditions',
            'foreignKey' => 'course_id',
            'associationForeignKey' => 'condition_id',
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
		'Person' => array(
			'className' => 'Person',
			'joinTable' => 'person_courses',
			'foreignKey' => 'course_id',
			'associationForeignKey' => 'person_id',
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
     * Get the sub list of dimension options when this model is used.
     *
     * @param array|integer $customer_id
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
            'Course.customer_id' => $report['Report']['customer_id']
        );

        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out courses.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Course') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_courses.'.$this->formatCacheConditions($conditions);
        $courses = Cache::read($cacheName, 'short');
        if (!$courses) {
            $courses = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, 'short');
        }
        return $courses;
    }

}
