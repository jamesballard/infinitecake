<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class Action extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'action';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Condition' => array(
            'className'     => 'Condition',
            'foreignKey'    => 'action'
        )
    );

    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user'
        ),
        'Group' => array(
            'className'    => 'Group',
            'foreignKey'   => 'group'
        )
    );

    public $hasOne = array(
        'Artefact' => array(
            'className'     => 'Artefact',
            'foreignKey'    => 'artefact'
        )
    );

    public function beforeSave($options = array()) {
        if (!empty($this->data['Event']['begindate']) && !empty($this->data['Event']['enddate'])) {
            $this->data['Event']['begindate'] = $this->dateFormatBeforeSave($this->data['Event']['begindate']);
            $this->data['Event']['enddate'] = $this->dateFormatBeforeSave($this->data['Event']['enddate']);
        }
        return true;
    }

    public function aggregateUserActions($dateString) {
        return date('Y-m-d', strtotime($dateString));
    }

}
