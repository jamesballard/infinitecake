<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property System $System
 * @property Action $Action
 * @property Condition $Condition
 * @property Module $Module
 * @property Role $Role
 */
class Group extends AppModel {

//Define Group Types
    const GROUP_TYPE_COURSE = 1; //A course group focuses around a shared curriculum and has fixed membership - the Course is the group.
    const GROUP_TYPE_PERSONAL = 2; //This focuses on an individual user (e.g. tutor or private) - the student is the group.
    const GROUP_TYPE_SOCIAL = 3; //A social group is self-forming and has open membership - the Group is the group.
    
    public $group_types = array(
    		Group::GROUP_TYPE_COURSE=>'Course',
    		Group::GROUP_TYPE_PERSONAL=>'Personal',
    		Group::GROUP_TYPE_SOCIAL=>'Social',
    );
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
		'System' => array(
			'className' => 'System',
			'foreignKey' => 'system_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'course_id',
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
		'Action' => array(
			'className' => 'Action',
			'foreignKey' => 'group_id',
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
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'group_id',
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
	);

	/**
	 * Returns a filtered list of axis points for visualisations.
	 *
	 * @param $report
	 * @return array|mixed
	 */
	public function getAxisPoints($report) {
		if(!empty($report['GroupCategory']['group_category_id'])) {
			$conditions = array(
				'GroupCategory.id' => $report['GroupCategory']['group_category_id']
			);
		} else {
			$conditions = array(
				'Group.id' => $report['Group']['groupid']
			);
		}

		$Filter = new Filter();
		// Add Custom filter WHERE clauses in case we filter out courses.
		foreach ($report['Filter'] as $filter) {
			if($filter['model'] == 'Course') {
				$conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
			}
		}

		$cacheName = 'customer_groups_axis.'.$this->formatCacheConditions($conditions);
		$groups = Cache::read($cacheName, 'short');
		if (!$groups) {
			$groups = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'group_categories',
						'alias' => 'GroupCategory',
						'type' => 'INNER',
						'conditions' => array(
							'Group.group_category_id = GroupCategory.id'
						)
					)
				),
				'conditions' => $conditions
			));
			Cache::write($cacheName, $groups, 'short');
		}
		return $groups;
	}
}
