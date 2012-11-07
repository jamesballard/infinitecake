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
}
