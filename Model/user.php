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
}
