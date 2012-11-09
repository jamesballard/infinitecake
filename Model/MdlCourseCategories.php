<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlCourseCategories extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'course_categories';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasOne = array(
        'Parent' => array(
            'className'    => 'MdlCourseCategories',
            'foreignKey'   => 'parent'
        )
    );
}
