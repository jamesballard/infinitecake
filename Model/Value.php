<?php
App::uses('AppModel', 'Model');
/**
 * Value Model
 *
 */
class Value extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

//Define Value Types
    const VALUE_TYPE_COUNT = 1;
    const VALUE_TYPE_SUM = 2;
    const VALUE_TYPE_AVG = 3;
    const VALUE_TYPE_MIN = 4;
    const VALUE_TYPE_MAX = 5;
    const VALUE_TYPE_STDDEV = 6;
    const VALUE_TYPE_VARIANCE = 7;
    const VALUE_TYPE_SELECT = 8;

    public $value_types = array(
        Value::VALUE_TYPE_COUNT=>'Count',
        Value::VALUE_TYPE_SUM=>'Sum',
        Value::VALUE_TYPE_AVG=>'Average',
        Value::VALUE_TYPE_MIN=>'Minimum',
        Value::VALUE_TYPE_MAX=>'Maximum',
        Value::VALUE_TYPE_STDDEV=>'Standard Deviation',
        Value::VALUE_TYPE_VARIANCE=>'Variance',
        Value::VALUE_TYPE_SELECT=>'Select',
    );

    public function getValueSql($type, $field) {
        switch ($type) {
            case Value::VALUE_TYPE_COUNT:
                return "COUNT($field)";
            case Value::VALUE_TYPE_SUM:
                return "SUM($field)";
            case Value::VALUE_TYPE_AVG:
                return "AVG($field)";
            case Value::VALUE_TYPE_MIN:
                return "MIN($field)";
            case Value::VALUE_TYPE_MAX:
                return "MAX($field)";
            case Value::VALUE_TYPE_STDDEV:
                return "STD($field)";
            case Value::VALUE_TYPE_VARIANCE:
                return "VARIANCE($field)";
            case Value::VALUE_TYPE_SELECT:
                return $field;
            default:
                break;
        }
    }

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ReportValue' => array(
            'className' => 'ReportValue',
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
