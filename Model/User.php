<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Person $Person
 * @property System $System
 * @property Action $Action
 * @property Condition $Condition
 * @property Role $Role
 */
class User extends AppModel {

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
		'Person' => array(
			'className' => 'Person',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'System' => array(
			'className' => 'System',
			'foreignKey' => 'system_id',
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
			'foreignKey' => 'user_id',
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
	 * Returns a filtered list of axis points for visualisations.
	 *
	 * @param $report
	 * @return array|mixed
	 */
	public function getAxisPoints($report) {
		if(!empty($report['UserGroup']['groupid'])) {
			$conditions = array(
				'UserGroup.group_id' => $report['UserGroup']['groupid']
			);
		} else {
			$conditions = array(
				'User.id' => $report['User']['userid']
			);
		}



		$Filter = new Filter();
		// Add Custom filter WHERE clauses in case we filter out courses.
		foreach ($report['Filter'] as $filter) {
			if($filter['model'] == 'Person') {
				$conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
			}
		}

		$cacheName = 'customer_users_axis.'.$this->formatCacheConditions($conditions);
		$users = Cache::read($cacheName, 'short');
		if (!$users) {
			$users = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'user_groups',
						'alias' => 'UserGroup',
						'type' => 'INNER',
						'conditions' => array(
							'User.id = UserGroup.user_id'
						)
					)
				),
				'conditions' => $conditions
			));
			Cache::write($cacheName, $users, 'short');
		}
		return $users;
	}

	/**
	 * Return users for a group.
	 * @param $groupid
	 * @return array|mixed
	 */
	public function get_group_users($groupid) {
		$conditions = array(
			'UserGroup.group_id' => $groupid
		);
		$cacheName = 'customer_group_users.'.$this->formatCacheConditions($conditions);
		$users = Cache::read($cacheName, 'short');
		if (!$users) {
			$users = $this->find('all', array(
				'joins' => array(
					array(
						'table' => 'user_groups',
						'alias' => 'UserGroup',
						'type' => 'INNER',
						'conditions' => array(
							'User.id = UserGroup.user_id'
						)
					)
				),
				'conditions' => $conditions
			));
			Cache::write($cacheName, $users, 'short');
		}
		return $users;
	}
}
