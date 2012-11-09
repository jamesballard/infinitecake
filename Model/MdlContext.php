MdlCourseCategories.php<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlContext extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'context';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Roles' => array(
            'className'     => 'MdlRoleAssignments',
            'foreignKey'    => 'contextid'
        )
    );

    public $hasOne = array(
        'Course' => array(
            'className'    => 'MdlCourse',
            'foreignKey'   => 'instance',
            'conditions'   => array('MdlContext.contextlevel' => '50')
        )
    );
}
