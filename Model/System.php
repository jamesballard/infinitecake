<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class System extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'system';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Group' => array(
            'className'     => 'Group',
            'foreignKey'    => 'system'
        ),
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'system'
        ),
        'Group' => array(
            'className'    => 'Group',
            'foreignKey'   => 'system'
        )
    );

    /*public $belongsTo = array(
        'Customer' => array(
            'className'    => 'Person',
            'foreignKey'   => 'person'
        )
    );*/

}
