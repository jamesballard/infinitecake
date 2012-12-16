<?php
App::uses('AppModel', 'Model');
/**
 * Membership Model
 *
 */
class Membership extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
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
            $aroRecord['Aro']['alias'] = $this->name . '::' . $this->data[$this->name][$this->displayField];
            $this->Aro->save($aroRecord);
        }
    }

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
