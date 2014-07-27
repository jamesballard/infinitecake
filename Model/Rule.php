<?php
App::uses('AppModel', 'Model');
App::uses('Condition', 'Model');
/**
 * Rule Model
 *
 * @property Artefact $Artefact
 * @property Community $Community
 * @property Person $Person
 */
class Rule extends AppModel {

//Define Rule Types
    const RULE_TYPE_ACTION = 1;
    const RULE_TYPE_VERB = 2;
    const RULE_TYPE_MODULE = 3;
    const RULE_TYPE_ARTEFACT = 4;
    const RULE_TYPE_GROUP = 5;
       
    public $rule_types = array(
    		Rule::RULE_TYPE_ACTION=>'Action',
    		Rule::RULE_TYPE_VERB=>'Verb',
    		Rule::RULE_TYPE_MODULE=>'Module',
    		Rule::RULE_TYPE_ARTEFACT=>'Artefact',
    		Rule::RULE_TYPE_GROUP=>'Course'
    	);

//Define Rule Categories
    const RULE_CAT_INTERACTION = 1;
    const RULE_CAT_INVOLVEMENT = 2;
    const RULE_CAT_INTIMACY = 3;
    const RULE_CAT_INFLUENCE = 4;

    public $rule_cats = array(
        Rule::RULE_CAT_INTERACTION=>'Interaction',
        Rule::RULE_CAT_INVOLVEMENT=>'Involvement',
        Rule::RULE_CAT_INTIMACY=>'Intimacy',
        Rule::RULE_CAT_INFLUENCE=>'Influence'
    );

//Define Rule Sub-categoriesruel_type
    const RULE_SUB_DESIGN = 1;
    const RULE_SUB_QUALITY = 2;
    const RULE_SUB_MANAGEMENT = 3;
    const RULE_SUB_VOICE = 4;
    const RULE_SUB_ACCESS = 5;

    public $rule_subs = array(
        Rule::RULE_SUB_DESIGN=>'Learning Design',
        Rule::RULE_SUB_QUALITY=>'Curriculum Quality',
        Rule::RULE_SUB_MANAGEMENT=>'Learner Management',
        Rule::RULE_SUB_VOICE=>'Learner Voice',
        Rule::RULE_SUB_ACCESS=>'Access'
    );
    
/**
 * static enum: Model::function()
 * @access static
 */
    public static function rule_types($value = null) {
    	$options = array(
    			self::RULE_TYPE_ACTION => __('Action',true),
    			self::RULE_TYPE_VERB => __('Verb',true),
    			self::RULE_TYPE_MODULE => __('Module',true),
    			self::RULE_TYPE_ARTEFACT => __('Artefact',true),
    			self::RULE_TYPE_GROUP => __('Course',true),
    	);
    	return parent::enum($value, $options);
    }

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

    public $hasAndBelongsToMany = array(
        'Condition' => array(
            'className' => 'Condition',
            'joinTable' => 'rule_conditions',
            'foreignKey' => 'rule_id',
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
     * Get the sub list of dimension options when this model is used.
     *
     * @param $customer_id integer
     * @return array a list formatted array
     */
    public function getDimensionParameters($customer_id) {
        return $this->find('list', array(
            'conditions' => array('customer_id' => $customer_id)
        ));
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
     * Get a join array to the Actions table.
     *
     * @param $type
     * @return array
     */
    protected function getJoinToAction($type) {
        switch ($type) {
            case 1:
                return array(
                    array(
                        'table' => 'action_conditions',
                        'alias' => 'ActionCondition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'ActionCondition.action_id = Action.id'
                        )
                    ),
                    array(
                        'table' => 'conditions',
                        'alias' => 'Condition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Condition.id = ActionCondition.condition_id'
                        )
                    ),
                );
            case 2:
                return array(
                    array(
                        'table' => 'dimension_verb_conditions',
                        'alias' => 'VerbCondition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'VerbCondition.dimension_verb_id = Action.dimension_verb_id'
                        )
                    ),
                    array(
                        'table' => 'conditions',
                        'alias' => 'Condition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Condition.id = VerbCondition.condition_id'
                        )
                    ),
                );
            case 3:
                return array(
                    array(
                        'table' => 'module_conditions',
                        'alias' => 'ModuleCondition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'ModuleCondition.module_id = Action.module_id'
                        )
                    ),
                    array(
                        'table' => 'conditions',
                        'alias' => 'Condition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Condition.id = ModuleCondition.condition_id'
                        )
                    ),
                );
            case 4:
                return array(
                    array(
                        'table' => 'artefact_conditions',
                        'alias' => 'ArtefactCondition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'ArtefactCondition.artefact_id = Action.artefact_id'
                        )
                    ),
                    array(
                        'table' => 'conditions',
                        'alias' => 'Condition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Condition.id = ArtefactCondition.condition_id'
                        )
                    ),
                );
            case 5:
                return array(
                    array(
                        'table' => 'groups',
                        'alias' => 'Group',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Group.id = Action.group_id'
                        )
                    ),
                    array(
                        'table' => 'course_conditions',
                        'alias' => 'CourseCondition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'CourseCondition.course_id = Group.course_id'
                        )
                    ),
                    array(
                        'table' => 'conditions',
                        'alias' => 'Condition',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Condition.id = CourseCondition.condition_id'
                        )
                    ),
                );
        }
    }

    protected function getJoinToConditions() {
        return array(
            array(
                'table' => 'rule_conditions',
                'alias' => 'RuleCondition',
                'type' => 'INNER',
                'conditions' => array(
                    'RuleCondition.condition_id = Condition.id'
                )
            ),
            array(
                'table' => 'conditions',
                'alias' => 'Rule',
                'type' => 'INNER',
                'conditions' => array(
                    'Rule.id = RuleCondition.rule_id'
                )
            ),
        );
    }

    /**
     * Returns record as labels for report.
     *
     * @param integer $id
     * @param integer $initial
     * @return array
     */
    public function getLabels($id, $initial) {
        $record = $this->read(null, $id);

        $labels = array();

        $joins = $this->getJoinToAction($record['Rule']['type']);
        $joins = array_merge($joins, $this->getJoinToConditions());

        $Condition = new Condition();
        $rule_conditions = $Condition->get_rule_conditions($record['Rule']['id']);
        foreach ($rule_conditions[0]['Condition'] as $rule_condition) {
            $labels[] =array(
                'name' => $rule_condition['name'],
                'start' => '',
                'end' => '',
                'joins' => $joins,
                'conditions' => array(
                    'Condition.id' => $rule_condition['id'],
                    'Rule.id' => $record['Rule']['id']
                ),
            );
        }
        return $labels;
    }

    /**
     * Get the x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     */
    public function getAxis($dimensions, $report) {
        $record = $this->read(null, $dimensions->axis['id']);
        $axis = array();
        $joins = $this->getJoinToAction($record['Rule']['type']);
        $joins = array_merge($joins, $this->getJoinToConditions());

        $conditions = array();
        if (!empty($report['Report']['datewindow'])) {
            $conditions = array(
                'DimensionDate.date >' => date('Y-m-d', strtotime($report['Report']['datewindow']))
            );
        }

        $Condition = new Condition();
        $rule_conditions = $Condition->get_rule_conditions($record['Rule']['id']);
        foreach ($rule_conditions[0]['Condition'] as $rule_condition) {
            $conditions = array_merge($conditions, array(
                'Condition.id' => $rule_condition['id'],
                'Rule.id' => $record['Rule']['id']
            ));
            $cache = false;
            $axis[] = array(
                'name' => $rule_condition['name'],
                'joins' => $joins,
                'conditions' => $conditions,
                'contain' => array('DimensionDate'),
                'cache' => $cache,
                'order' => ''
            );
        }
        return $axis;
    }


    /**
     * Returns a list formatted array of rules for multi-select form
     *
     * @param $customer_id integer
     * @return array
     */
    public function getCustomerRules($customer_id) {
        return $this->find('all', array(
            'contain' => false,
            'conditions' => array(
                'customer_id' => array(
                    1, //TO DO all customer ID cannot be called from Controller to Model
                    $customer_id
                )
            )
        ));
    }

    /**
     * Returns a list formatted array of rules for multi-select form
     *
     * @param $customer_id integer
     * @param $rule_type integer
     * @return array
     */
    public function getRulesListByCustomerAndType($customer_id, $rule_type) {
        return $rulesRecords = $this->find('list', array(
            'contain' => false,
            'conditions' => array(
                'customer_id' => array(
                    1, //TO DO all customer ID cannot be called from Controller to Model
                    $customer_id
                ),
                'type' => $rule_type
            )
        ));
    }

    /**
     * Returns a filtered list of axis points for visualisations.
     *
     * @param $report
     * @return array|mixed
     */
    public function getAxisPoints($report) {
        //TODO: can a rule appear on x-axis or just a label?

        $joins = $this->getJoinToConditions();

        $conditions = array(
            'Rule.customer_id' => $report['Report']['customer_id']
        );
        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out artefacts.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Rule') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $Condition = new Condition();
        //$rule_conditions = $Condition->get_rule_conditions($record['Rule']['id']);
        //foreach ($rule_conditions[0]['Condition'] as $rule_condition) {

        //}

        $cacheName = 'customer_rules.'.$this->formatCacheConditions($conditions);
        $artefacts = Cache::read($cacheName, 'short');
        if (!$artefacts) {
            $artefacts = $this->find('all', array(
                'conditions' => $conditions,
                'joins' => $joins
            ));
            Cache::write($cacheName, $artefacts, 'short');
        }
        return $artefacts;
    }
}
