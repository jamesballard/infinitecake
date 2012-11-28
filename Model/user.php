<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class User extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'user';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Action' => array(
            'className'     => 'Action',
            'foreignKey'    => 'user'
        )
    );

    public $belongsTo = array(
        'Person' => array(
            'className'    => 'Person',
            'foreignKey'   => 'person'
        ),
        'System' => array(
            'className'    => 'System',
            'foreignKey'   => 'system'
        )
    );

    var $hasAndBelongsToMany = array(
        'Group' => array(
            'className' => 'Group',
            'joinTable' => 'role',
            'foreignKey' => 'user',
            'associationForeignKey' => 'group'
        )
    );

    /**
     * Returns the idnumber of a user given the primary key
     *
     * @param   integer $id primary key for user
     * @return  array   Array with these options : 'id', 'idnumber'
     */
    public function getUser($id) {
        $result = $this->find('first', array(
            'recursive' => -1, //int
            'fields' => array('id', 'idnumber'), //array of field names
            'conditions' => array('id' => $id)
        ));
        return $result;
    }
}
