<?php
App::uses('AppModel', 'Model');
App::uses('Artefact', 'Model');
App::uses('Course', 'Model');
App::uses('Module', 'Model');
App::uses('DimensionVerb', 'Model');
App::uses('Period', 'Model');
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

    protected function getCondition($filter) {
        $filterModel = new $filter['model']();
        switch ($filter['comparison']) {
            case self::FILTER_COMPARISON_EQUAL:
                return array($filter['model'].'.'.$filterModel->displayField => $filter['value']);
            case self::FILTER_COMPARISON_NOTEQUAL:
                return array($filter['model'].'.'.$filterModel->displayField.' !=' => $filter['value']);
            case self::FILTER_COMPARISON_BEGINSWITH:
                return array($filter['model'].'.'.$filterModel->displayField.' LIKE' => $filter['value'].'%');
            case self::FILTER_COMPARISON_ENDSWITH:
                return array($filter['model'].'.'.$filterModel->displayField.' LIKE' => '%'.$filter['value']);
            case self::FILTER_COMPARISON_CONTAINS:
                return array($filter['model'].'.'.$filterModel->displayField.' LIKE' => '%'.$filter['value'].'%');
            case self::FILTER_COMPARISON_NOTCONTAINS:
                return array($filter['model'].'.'.$filterModel->displayField.' NOT LIKE' => '%'.$filter['value'].'%');
            default:
                return array($filter['model'].'.'.$filterModel->displayField => $filter['value']);
        }
    }

    public function getFilterCondition($filter) {
        $condition = array();
        // Set the operator.
        $filter['operator'] ? $operator = $this->filter_operators[$filter['operator']] : $operator = 'AND';
        $condition[$operator] = $this->getCondition($filter);
        return $condition;
    }

    protected function getComparisonSQL($comparison=self::FILTER_COMPARISON_EQUAL, $value) {
        switch ($comparison) {
            case self::FILTER_COMPARISON_EQUAL:
                return "= '$value'";
            case self::FILTER_COMPARISON_NOTEQUAL:
                return "!= '$value'";
            case self::FILTER_COMPARISON_BEGINSWITH:
                return "LIKE '$value%'";
            case self::FILTER_COMPARISON_ENDSWITH:
                return "LIKE '%$value'";
            case self::FILTER_COMPARISON_CONTAINS:
                return "LIKE '%$value%'";
            case self::FILTER_COMPARISON_NOTCONTAINS:
                return "NOT LIKE '%$value%'";
            default:
                return "= '$value'";
        }
    }

    public function getFilterSQL($filter) {
        $operator = $filter['operator'];
        $filterModel = new $filter['model']();
        // Set the operator.
        $sql = ($operator ? $this->filter_operators[$operator] : 'AND ').' ';
        // Set the model and field.
        $sql .= $filter['model'].'.'.$filterModel->displayField.' ';
        // Set the comparison.
        $sql .= $this->getComparisonSQL($filter['comparison'], $filter['value']).' ';
        return $sql;
    }
}
