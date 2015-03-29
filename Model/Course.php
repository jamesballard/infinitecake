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
     * Count the number of courses for a given customer.
     *
     * @param $customer_id
     * @return array|mixed
     */
    public function countCustomerCourses($customer_id) {
        $conditions = array('Customer.id' => $customer_id);
        $cacheName = 'customer_course_count.'.$this->formatCacheConditions($conditions);
        $courses = Cache::read($cacheName, 'short');
        if (!$courses) {
            $courses = $this->find('count', array(
                    'contain' => false,
                    'joins' => array(
                        array(
                            'table' => 'customers',
                            'alias' => 'Customer',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Customer.id = Course.customer_id'
                            )
                        ),
                    ),
                    'conditions' => $conditions
                )
            );
            Cache::write($cacheName, $courses, 'short');
        }
        return $courses;
    }

    /**
     * Returns an array of courses based on a customer id
     * @param int $customer_id - the id of a customer
     * @return array of artefacts
     */
    public function getCustomerCourses($customer_id = null) {
        if(empty($customer_id)) return false;
        $conditions = array(
            'Course.customer_id' => $customer_id
        );
        $cacheName = 'customer_courses_all.'.$this->formatCacheConditions($conditions);
        $courses = Cache::read($cacheName, 'short');
        if (!$courses) {
            $courses = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, $courses, 'short');
        }
        return $courses;
    }

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
     * Returns record as labels for report.
     *
     * @param integer $id
     * @param mixed $report
     * @return array
     */
    public function getLabels($id, $report) {
        $labels = array();
        $courses = $this->getCustomerCourses($report['Report']['customer_id']);
        foreach ($courses as $course) {
            $labels[] =array(
                'name' => $course['Course']['name'],
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'Course.id' => $course['Course']['id']
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
            'Course.customer_id' => $report['Report']['customer_id']
        );

        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out courses.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Course') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_course_axis.'.$this->formatCacheConditions($conditions);
        $courses = Cache::read($cacheName, 'short');
        if (!$courses) {
            $courses = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, $courses, 'short');
        }
        return $courses;
    }

}
