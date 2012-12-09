<?php
App::uses('AppModel', 'Model');
/**
 * Member Model
 *
 * @property Group $Group
 */
class Member extends AppModel {

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
	public $belongsTo = array('Membership');
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
        return array('model' => 'Membership', 'foreign_key' => 1);
    }

    public function beforeSave($options = array()) {
        $this->data['Member']['password'] = AuthComponent::password($this->data['Member']['password']);
        return true;
    }
}
