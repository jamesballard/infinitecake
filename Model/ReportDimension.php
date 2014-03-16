<?php
App::uses('AppModel', 'Model');
/**
 * ReportDimension Model
 *
 * @property Report $Report
 * @property Dimension $Dimension
 */
class ReportDimension extends AppModel {

    //Define Dimension Types
    const DIMENSION_TYPE_AXIS = 1;
    const DIMENSION_TYPE_LABEL = 2;

    public $dimension_types = array(
        self::DIMENSION_TYPE_AXIS=>'x-Axis',
        self::DIMENSION_TYPE_LABEL=>'Label',
    );

// Define the supported dimension models.
    const DIMENSION_ARTEFACT = 'Artefact';
    const DIMENSION_COURSE = 'Course';
    const DIMENSION_DATE = 'DimensionDate';
    const DIMENSION_TIME = 'DimensionTime';
    const DIMENSION_DEPARTMENT = 'Department';
    const DIMENSION_GROUP = 'Group';
    const DIMENSION_MODULE = 'Module';
    const DIMENSION_PERIOD = 'Period';
    const DIMENSION_PERSON = 'Person';
    const DIMENSION_RULE = 'Rule';

    public $dimension_models = array(
        self::DIMENSION_ARTEFACT => 'Artefact',
        self::DIMENSION_COURSE => 'Course',
        self::DIMENSION_DATE => 'Date',
        self::DIMENSION_TIME => 'Hour',
        self::DIMENSION_DEPARTMENT => 'Department',
        self::DIMENSION_MODULE => 'Module',
        self::DIMENSION_PERIOD => 'Period',
        self::DIMENSION_PERSON => 'Person',
        self::DIMENSION_RULE => 'Rule',
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
