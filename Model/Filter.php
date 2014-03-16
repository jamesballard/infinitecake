<?php
App::uses('AppModel', 'Model');
/**
 * Filter Model
 *
 * @property Report $Report
 */
class Filter extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

//Define filter types.
    const FILTER_TYPE_VALUE = 1;
    const FILTER_TYPE_LIST = 2;
    const FILTER_TYPE_RANK = 3;
    const FILTER_TYPE_NUMERIC = 4;
    const FILTER_TYPE_VARIABLE = 5;

    public $filter_types = array(
        self::FILTER_TYPE_VALUE => 'Value',
        self::FILTER_TYPE_LIST => 'List',
        self::FILTER_TYPE_RANK => 'Ranking',
        self::FILTER_TYPE_NUMERIC => 'Numeric',
        self::FILTER_TYPE_VARIABLE => 'Variable'
    );

//Define filter operators.
    const FILTER_OPERATOR_AND = 1;
    const FILTER_OPERATOR_OR = 2;

    public $filter_operators = array(
        self::FILTER_OPERATOR_AND => 'And',
        self::FILTER_OPERATOR_OR => 'Or',
    );

//Define filter comparisons.
    const FILTER_COMPARISON_EQUAL = 1;
    const FILTER_COMPARISON_NOTEQUAL = 2;
    const FILTER_COMPARISON_BEGINSWITH = 3;
    const FILTER_COMPARISON_ENDSWITH = 4;
    const FILTER_COMPARISON_CONTAINS = 5;
    const FILTER_COMPARISON_NOTCONTAINS = 6;

    public $filter_comparisons = array(
        self::FILTER_COMPARISON_EQUAL => 'is',
        self::FILTER_COMPARISON_NOTEQUAL => 'is not',
        self::FILTER_COMPARISON_BEGINSWITH => 'begins with',
        self::FILTER_COMPARISON_ENDSWITH => 'ends with',
        self::FILTER_COMPARISON_CONTAINS => 'contains',
        self::FILTER_COMPARISON_NOTCONTAINS => 'does not contain'
    );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'report_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Report' => array(
			'className' => 'Report',
			'foreignKey' => 'report_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
