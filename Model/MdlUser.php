<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 20:49
 */
class MdlUser extends AppModel {
// define which database driver the model
// needs to look upon
    var $useDbConfig = 'lcmoodle';
// Table Name
    var $useTable = 'user';
    var $primaryKey = 'id';
    var $cacheQueries = true;

    public $hasMany = array(
        'Log' => array(
            'className'     => 'MdlLog',
            'foreignKey'    => 'userid',
        ),
        'Roles' => array(
            'className'    => 'MdlRoleAssignments',
            'foreignKey'   => 'userid'
        ),
    );

    /**
     * Returns the idnumber of a user given the primary key
     *
     * @param   integer $id primary key for user
     * @return  array   Array with these options : 'id', 'idnumber'
     */
    public function getUser($id) {
        $result = $this->find('all', array(
            'recursive' => -1, //int
            'fields' => array('id', 'idnumber'), //array of field names
            'conditions' => array('id' => $id)
        ));
        return $result;
    }

}
