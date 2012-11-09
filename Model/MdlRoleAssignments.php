<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlRoleAssignments extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'role_assignments';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasOne = array(
        'User' => array(
            'className'    => 'MdlUser',
            'foreignKey'   => 'userid'
        ),
        'Context' => array(
            'className'    => 'MdlContext',
            'foreignKey'   => 'contextid'
        ),
        'Role' => array(
            'className'    => 'MdlRole',
            'foreignKey'   => 'roleid'
        )
    );
}
