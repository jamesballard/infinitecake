<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class Group extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'group';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Action' => array(
            'className'     => 'Action',
            'foreignKey'    => 'group'
        )
    );

    public $belongsTo = array(
        'System' => array(
            'className'    => 'System',
            'foreignKey'   => 'system'
        )
    );

    var $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'role',
            'foreignKey' => 'group',
            'associationForeignKey' => 'user'
        )
    );
}
