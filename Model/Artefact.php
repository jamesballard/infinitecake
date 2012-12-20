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

    //Define Artefact Types
    const ARTEFACT_TYPE_ASSESSMENT = 1;
    const ARTEFACT_TYPE_COMMUNICATION = 2;
    const ARTEFACT_TYPE_COLLABORATION = 3;
    const ARTEFACT_TYPE_RESOURCE = 4;
    const ARTEFACT_TYPE_OPERATION = 5;

    public $validate = array('name' => 'unique');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Community' => array(
			'className' => 'Community',
			'foreignKey' => 'community_id',
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
		),
		'Dirobject' => array(
			'className' => 'Dirobject',
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
		),
		'Rule' => array(
			'className' => 'Rule',
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

    public function getArtefacts() {
        // Define the artefacts for reports
        return $this->find('all', array(
                                'fields' => array('id', 'name', 'type'),
                                'recursive' => -1,
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
