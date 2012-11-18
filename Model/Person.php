<?php
App::uses('AppModel', 'Model');
/**
 * User
 *
 */

class Person extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'default';
// Table Name
    var $useTable = 'person';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'person'
        )
    );

    var $hasAndBelongsToMany = array(
        'Community' => array(
            'className' => 'Community',
            'foreignKey' => 'community',
        )
    );

}
