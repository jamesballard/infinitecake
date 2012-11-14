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

    /**
     * Returns the idnumber of a user given the primary key
     *
     * @param   integer $id primary key for user
     * @return  array   Array with these options : 'id', 'idnumber'
     */
    public function getCourse($id) {
        $result = $this->find('all', array(
            'recursive' => -1, //int
            'fields' => array('id', 'idnumber'), //array of field names
            'conditions' => array('id' => $id)
        ));
        return $result;
    }

}
