<?php
App::uses('AppModel', 'Model');
/**
 * Member Model
 *
 * @property Group $Group
 */
class Member extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'firstname';
   

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'membership_id' => array(
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
	public $belongsTo = array('Membership', 
				'Customer' => array(
						'className' => 'Customer',
						'foreignKey' => 'customer_id',
						'conditions' => '',
						'fields' => '',
						'order' => ''
				)
			);
    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['Member']['membership_id'])) {
            $membershipId = $this->data['Member']['membership_id'];
        } else {
            $membershipId = $this->field('membership_id');
        }
        if (!$membershipId) {
            return null;
        } else {
            return array('Membership' => array('id' => $membershipId));
        }
    }

    public function bindNode($user) {
        return array('model' => 'Membership', 'foreign_key' => $user['Member']['Member']['membership_id']);
    }

/**
 * Encrypt password storage
 */

    public function beforeSave($options = array()) {
        $this->data['Member']['password'] = AuthComponent::password($this->data['Member']['password']);
        return true;
    }

/* ACL afterSave Fix, as the default acl-behavior does not save an aro's alias
 * I have created this function which can be dropped into ANY model. It will
 * hook on after the acl-behavior has finished and set the correct alias
 * depending on model used. No modification required.
 *
 * Requires: displayField and name be set in model!
 *
 * Created: 26th May 2011
 * Author : Simon Dann
 * Version: 1.0.0
 * http://bakery.cakephp.org/articles/carbontwelve/2011/05/26/update_aro_alias_on_save
 */

    function afterSave($created=false){

        $saveAro = false;

        if ($this->getLastInsertID()){
            $saveAro = true;
            $insertId = $this->getLastInsertID();
        }else{
            if ($this->data[$this->name]['id']){
                $saveAro = true;
                $insertId = $this->data[$this->name]['id'];
            }
        }
        if ($saveAro == true){
            $aroRecord = $this->Aro->find('first', array('conditions' => array('foreign_key' => $insertId, 'model' => $this->name)));
            $aroRecord['Aro']['alias'] = $this->name . '::' . $this->data[$this->name][$this->username];
            $this->Aro->save($aroRecord);
        }
    }

    public function getMembership($username) {
        return $this->find('first', array(
                'conditions' => array('username' => $username),
                'contain' => false, 
                'fields' => array('Member.membership_id'),
            )
        );
    }
}
