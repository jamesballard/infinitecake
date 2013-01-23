<?php
App::uses('AppModel', 'Model');
/**
 * Artefact Model
 *
 * @property Community $Community
 * @property Module $Module
 * @property Object $Object
 * @property Rule $Rule
 */
class Artefact extends AppModel {
	
	public $actsAs = array('Containable');

//Define Artefact Types
    const ARTEFACT_TYPE_ASSESSMENT = 1;
    const ARTEFACT_TYPE_COMMUNICATION = 2;
    const ARTEFACT_TYPE_COLLABORATION = 3;
    const ARTEFACT_TYPE_RESOURCE = 4;
    const ARTEFACT_TYPE_OPERATION = 5;
    
    public $artefact_types = array(
    		Artefact::ARTEFACT_TYPE_ASSESSMENT=>'Assessment',
    		Artefact::ARTEFACT_TYPE_COMMUNICATION=>'Communication',
    		Artefact::ARTEFACT_TYPE_COLLABORATION=>'Collaboration',
    		Artefact::ARTEFACT_TYPE_RESOURCE=>'Resource',
    		Artefact::ARTEFACT_TYPE_OPERATION=>'Operation'
    	);

    public $validate = array(
        'name' => array(
            'rule'    => 'isUnique',
            'message' => 'This name has already been taken.'
        )
    );

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'artefact_id',
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
            'joinTable' => 'artefact_conditions',
            'foreignKey' => 'artefact_id',
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

    public function getArtefacts() {
        // Define the artefacts for reports
        return $this->find('all', array(
                                'fields' => array('id', 'name', 'type'),
                                'contain' => false,
                                'conditions' => array('type' => array(
                                    Artefact::ARTEFACT_TYPE_ASSESSMENT,
                                    Artefact::ARTEFACT_TYPE_COMMUNICATION,
                                    Artefact::ARTEFACT_TYPE_COLLABORATION,
                                    Artefact::ARTEFACT_TYPE_RESOURCE
                                    )
                                )
                           )
            );
    }

}
