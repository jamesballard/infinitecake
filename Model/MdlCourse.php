<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlCourse extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'course';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Log' => array(
            'className'     => 'MdlLog',
            'foreignKey'    => 'course'
        )
    );

    public $hasOne = array(
        'Category' => array(
            'className'    => 'MdlCourseCategories',
            'foreignKey'   => 'category'
        ),
        'Context' => array(
            'className'    => 'MdlContext',
            'foreignKey'   => 'instance',
            'conditions'   => array('MdlContext.contextlevel' => '50')
        )
    );

}