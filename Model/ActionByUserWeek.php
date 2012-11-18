<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class ActionByUserWeek extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action_by_user_week';
    var $cacheQueries = true;

    public $dateFormat = 'Y-m-d';

}
