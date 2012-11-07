<?php
App::uses('AppModel', 'Model');
/**
 * LcmoodleLog Model
 *
 */

class MdlLog extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'log';
    var $primaryKey = 'id';
    var $cacheQueries = true;
}
