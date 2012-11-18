<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class ActionByUserDay extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action_by_user_day';
    var $cacheQueries = true;

    public $dateFormat = 'Y-m-d';
}
