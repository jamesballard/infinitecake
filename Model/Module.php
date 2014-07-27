<?php
App::uses('AppModel', 'Model');
/**
 * Module Model
 *
 * @property Artefact $Artefact
 * @property Group $Group
 * @property System $System
 * @property Action $Action
 * @property Condition $Condition
 * @property Material $Material
 */
class Module extends AppModel {

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
		'Artefact' => array(
			'className' => 'Artefact',
			'foreignKey' => 'artefact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
			'foreignKey' => 'module_id',
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

    public $hasAndBelongsToMany = array(
        'Condition' => array(
            'className' => 'Condition',
            'joinTable' => 'module_conditions',
            'foreignKey' => 'module_id',
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
        )
    );

    /**
     * Returns an array of modules based on a customer id
     * @param int $customer_id - the id of a customer
     * @return array of modules
     */
    public function getCustomerModules($customer_id = null) {
        if(empty($customer_id)) return false;
        $conditions = array(
            'System.customer_id' => $customer_id
        );
        $cacheName = 'customer_modules.'.$this->formatCacheConditions($conditions);
        $modules = Cache::read($cacheName, 'short');
        if (!$modules) {
            $modules = $this->find('all', array(
                'joins' => array(
                    array('table' => 'systems',
                        'alias' => 'System',
                        'type' => 'INNER',
                        'conditions' => $conditions
                    )
                ),
                'group' => 'Module.id'
            ));
            Cache::write($cacheName, $modules, 'short');
        }
        return $modules;
    }

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
        $modules = $this->find('all', array(
            'contain' => array(
                'System' => array(
                    'fields' => array(
                        'System.customer_id'
                    )
                ),
            ),
            'conditions' => array(
                'System.customer_id' => array(
                    $customer_id
                )
            ),
            'fields' => array('Module.id as id', 'Module.name as name'),
            'order' => array('name' => 'ASC')
        ));
        return Set::combine($modules, '{n}.Module.id', '{n}.Module.name');
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
        $modules = $this->getCustomerModules($report['Report']['customer_id']);
        foreach ($modules as $module) {
            $labels[] =array(
                'name' => $module['Module']['name'],
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'Artefact.id' => $module['Module']['id']
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
        $joinconditions = array(
            'System.customer_id' => $report['Report']['customer_id'],
            'Module.system_id = System.id'
        );

        $conditions = array();
        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out artefacts.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Module') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_modules.'.$this->formatCacheConditions($conditions);
        $modules = Cache::read($cacheName, 'short');
        if (!$modules) {
            $modules = $this->find('all', array(
                'conditions' => $conditions,
                'joins' => array(
                    array('table' => 'systems',
                        'alias' => 'System',
                        'type' => 'INNER',
                        'conditions' => $joinconditions
                    )
                )
            ));
            Cache::write($cacheName, $modules, 'short');
        }
        return $modules;
    }
}
