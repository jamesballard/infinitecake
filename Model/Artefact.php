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

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

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
        ),
        'Customer' => array(
            'className' => 'Customer',
            'joinTable' => 'customer_artefacts',
            'foreignKey' => 'artefact_id',
            'associationForeignKey' => 'customer_id',
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
    public function getDimensionParameters($customer_id) {
        return array(0 => __('No option required'));
    }

    /**
     * Get the sub list of dimension options when this model is used.
     *
     * @param array|integer $customer_id
     * @return array a list formatted array
     */
    public function getFilterOptions($customer_id) {
        $artefacts = $this->getArtefactsByCustomerId($customer_id);
        return Set::combine($artefacts, '{n}.Artefact.id', '{n}.Artefact.name');
    }

    public function getArtefacts() {
        // Define the artefacts for reports
        $conditions = array('type' => array(
            Artefact::ARTEFACT_TYPE_ASSESSMENT,
            Artefact::ARTEFACT_TYPE_COMMUNICATION,
            Artefact::ARTEFACT_TYPE_COLLABORATION,
            Artefact::ARTEFACT_TYPE_RESOURCE
            )
        );
        $cacheName = 'artefacts_all.'.$this->formatCacheConditions($conditions);
        $artefacts = Cache::read($cacheName, 'short');
        if (!$artefacts) {
            $artefacts = $this->find('all', array(
                    'fields' => array('id', 'name', 'type'),
                    'contain' => false,
                    'conditions' => $conditions
                )
            );
            Cache::write($cacheName, $artefacts, 'short');
        }
        return $artefacts;
    }

    /**
     * Returns an array of artefacts based on a customer id
     * @param int $customer_id - the id of a customer
     * @return array of artefacts
     */
    public function getArtefactsByCustomerId($customer_id = null) {
        if(empty($customer_id)) return false;
        $conditions = array(
            'CustomerArtefact.customer_id' => $customer_id,
            'CustomerArtefact.artefact_id = Artefact.id'
        );
        $cacheName = 'customer_artefacts.'.$this->formatCacheConditions($conditions);
        $artefacts = Cache::read($cacheName, 'short');
        if (!$artefacts) {
            $artefacts = $this->find('all', array(
                'joins' => array(
                    array('table' => 'customer_artefacts',
                        'alias' => 'CustomerArtefact',
                        'type' => 'INNER',
                        'conditions' => $conditions
                    )
                ),
                'group' => 'Artefact.id'
            ));
            Cache::write($cacheName, 'short');
        }
        return $artefacts;
    }

    /**
     * Returns a filtered list of axis points for visualisations.
     *
     * @param $report
     * @return array|mixed
     */
    public function getAxisPoints($report) {
        $joinconditions = array(
            'CustomerArtefact.customer_id' => $report['Report']['customer_id'],
            'CustomerArtefact.artefact_id = Artefact.id'
        );

        $conditions = array();
        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out artefacts.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Artefact') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_artefacts.'.$this->formatCacheConditions($conditions);
        $artefacts = Cache::read($cacheName, 'short');
        if (!$artefacts) {
            $artefacts = $this->find('all', array(
                'conditions' => $conditions,
                'joins' => array(
                    array('table' => 'customer_artefacts',
                        'alias' => 'CustomerArtefact',
                        'type' => 'INNER',
                        'conditions' => $joinconditions
                    )
                ),
                'group' => 'Artefact.id'
            ));
            Cache::write($cacheName, 'short', $artefacts);
        }
        return $artefacts;
    }

    public function dimensionForAction($action) {
        $cacheName = 'customer_artefacts.'.$action['module_id'];
        $artefact = Cache::read($cacheName, 'long');
        if (!$artefact) {
            $artefact = $this->find('all', array(
                'conditions' => array(
                    'Module.id' => $action['module_id']
                ),
                'joins' => array(
                    array('table' => 'modules',
                        'alias' => 'Module',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Module.artefact_id' => 'Artefact.id'
                        )
                    )
                ),
                'group' => 'Artefact.id'
            ));
            Cache::write($cacheName, 'long', $artefact);
        }
        return $artefact;
    }
}
