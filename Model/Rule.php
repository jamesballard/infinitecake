<?php
App::uses('AppModel', 'Model');
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
}
