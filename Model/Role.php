<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class Role extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'role';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user'
        ),
        'Group' => array(
            'className'    => 'Group',
            'foreignKey'   => 'group'
        )
    );

}
