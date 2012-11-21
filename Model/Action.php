<?php
App::uses('AppModel', 'Model');
App::uses('ActionByUserDay', 'Model');
App::uses('ActionByUserHour', 'Model');
App::uses('ActionByUserMonth', 'Model');
App::uses('ActionByUserWeek', 'Model');
App::uses('MdlLog', 'Model');
/**
 * User
 *
 */

class Action extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Condition' => array(
            'className'     => 'Condition',
            'foreignKey'    => 'action'
        )
    );

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

    public $hasOne = array(
        'Artefact' => array(
            'className'     => 'Artefact',
            'foreignKey'    => 'artefact'
        )
    );

}
