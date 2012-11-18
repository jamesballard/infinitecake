<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class ActionByUserHour extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action_by_user_hour';
    var $cacheQueries = true;

}
