<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class Community extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'community';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Group' => array(
            'className'     => 'Group',
            'foreignKey'    => 'community'
        ),
        'Person' => array(
            'className'    => 'Person',
            'foreignKey'   => 'community'
        )
    );

    /*public $belongsTo = array(
        'Customer' => array(
            'className'    => 'Person',
            'foreignKey'   => 'person'
        )
    );*/

}
