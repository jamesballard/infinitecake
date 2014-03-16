<?php
App::uses('AppModel', 'Model');
/**
 * Dimension Model
 *
 */
class Dimension extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

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
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'ReportDimension' => array(
            'className' => 'ReportDimension',
            'foreignKey' => 'report_id',
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

}
