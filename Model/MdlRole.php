MdlCourseCategories.php<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlRole extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'role';
    var $primaryKey = 'id';
    var $cacheQueries = true;
}
