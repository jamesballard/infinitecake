<?php
App::uses('AppModel', 'Model');
/**
 * Condition Model
 *
 * @property Module $Module
 * @property Group $Group
 * @property User $User
 */
class Condition extends AppModel {

//Define Artefact Types
    const CONDITION_TYPE_USER = 1; //This has been created by auser through GUI.
    const CONDITION_TYPE_IP = 2; //This is an IP address generated by an external system.

    var $condition_types = array(
    		Condition::CONDITION_TYPE_USER=>'User',
    		Condition::CONDITION_TYPE_IP=>'IP Address'
    	);

    //public $filtertype = 'select';
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
	
/**
 * belongsTo associations
 *
 * @var array
 */
    public $hasAndBelongsToMany = array(
        'Rule' => array(
            'className' => 'Rule',
            'joinTable' => 'rule_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'rule_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Action' => array(
            'className' => 'Action',
            'joinTable' => 'action_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'action_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'DimensionVerb' => array(
            'className' => 'DimensionVerb',
            'joinTable' => 'dimension_verb_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'dimension_verb_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Artefact' => array(
            'className' => 'Artefact',
            'joinTable' => 'artefact_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'artefact_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Course' => array(
            'className' => 'Course',
            'joinTable' => 'course_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'course_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Module' => array(
            'className' => 'Module',
            'joinTable' => 'module_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'module_id',
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
     * @param array|integer $customer_id
     * @return array a list formatted array
     */
    public function getFilterOptions($customer_id) {
        return $this->find('list', array(
            'conditions' => array('customer_id' => $customer_id)
        ));
    }

    /**
     * given a rule ID returns the condition related to it
     *
     * @param integer rule_id
     * @var array
     */

    public function get_rule_conditions($rule_id) {
        return $this->Rule->find('all', array(
        	'recursive' => 1,
            'conditions' => array(
                'Rule.id' => $rule_id
            ),
            'contain' => array(
                'Condition' => array(
                    'fields' => array('Condition.id', 'Condition.name'),
                )
            ),
        ));
    }

    public function getCourseConditions($customer_id) {
        return $this->Course->find('all', array(
            'contain' => array(
                'Department' => array(
                    'fields' => array(
                        'Department.id',
                        'Department.name',
                        'Department.customer_id'
                    )
                )
            ),
            'conditions' => array(
                'Department.customer_id' => array(
                    $customer_id
                )
            ),
            'fields' => array('Course.id as id', 'CONCAT(Course.name, " (",Course.idnumber,")") as name'),
            'order' => array('name' => 'ASC')
        ));
    }

    public function getModuleConditions($customer_id) {
        return $this->Module->find('all', array(
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
            'fields' => array('Module.id as id', 'Module.sysid as name'),
            'order' => array('name' => 'ASC')
        ));
    }

    public function getVerbConditions() {
        return $this->DimensionVerb->find('all', array(
            'contain' => array(
                'Artefact' => array(
                    'fields' => array(
                        'Artefact.name'
                    )
                ),
            ),
            'fields' => array('id', 'CONCAT(Artefact.name, ": ",DimensionVerb.sysname) as name'),
            'order' => array('name' => 'ASC')
        ));
    }

}
