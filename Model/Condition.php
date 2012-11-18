<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class Condition extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'condition';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $belongsTo = array(
        'Action' => array(
            'className'    => 'Action',
            'foreignKey'   => 'action'
        )
    );

}
