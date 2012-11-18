<?php
App::uses('AppModel', 'Model');
App::uses('ActionByUserDay', 'Model');
App::uses('ActionByUserHour', 'Model');
App::uses('ActionByUserMonth', 'Model');
App::uses('ActionByUserWeek', 'Model');
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

    /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function getConditions($data) {
        $data = array(
            'user'=>$data['Action']['user'],
            'group'=>$data['Action']['group'],
            'artefact'=>$data['Action']['artefact'],
            'action'=>$data['Action']['name']
        );
        return $data;
    }

    /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function updateHourAggregation($data) {
        $ActionByUserHour = new ActionByUserHour();
        $conditions = $this->getConditions($data);
        $time = new DateTime(date($ActionByUserHour->dateFormat, $data['Action']['time']));
        //TODO - localise times: $time->setTimezone(new DateTimeZone('Pacific/Chatham'));
        $conditions['time'] = $time->format('U');
        $conditions['hour'] = $time->format('G');

        $count = $ActionByUserHour->find('all', array(
            'conditions' => $conditions
        ));

        if($count) {
            //update the current count
            $conditions['id'] = $count[0]['ActionByUserHour']['id'];
            $total = $count[0]['ActionByUserHour']['total'];
            $total++;
            $conditions['total'] = $total;
            $ActionByUserHour->save($conditions);
        }else{
            //start a new count
            $conditions['total'] = 1;
            $ActionByUserHour->save($conditions);
        }
    }

    /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function updateDayAggregation($data) {
        $ActionByUserDay = new ActionByUserDay();
        $conditions = $this->getConditions($data);
        $time = new DateTime(date($ActionByUserDay->dateFormat, $data['Action']['time']));
        //TODO - localise times: $time->setTimezone(new DateTimeZone('Pacific/Chatham'));
        $conditions['time'] = $time->format('U');

        $count = $ActionByUserDay->find('all', array(
            'conditions' => $conditions
        ));

        if($count) {
            //update the current count
            $conditions['id'] = $count[0]['ActionByUserDay']['id'];
            $total = $count[0]['ActionByUserDay']['total'];
            $total++;
            $conditions['total'] = $total;
            $ActionByUserDay->save($conditions);
        }else{
            //start a new count
            $conditions['total'] = 1;
            $ActionByUserDay->save($conditions);
        }
    }

    /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function updateWeekAggregation($data) {
        $ActionByUserWeek = new ActionByUserWeek();
        $conditions = $this->getConditions($data);
        $time = new DateTime(date($ActionByUserWeek->dateFormat, $data['Action']['time']));
        //TODO - localise times: $time->setTimezone(new DateTimeZone('Pacific/Chatham'));
        $conditions['week'] = $time->format('W');
        $conditions['year'] = $time->format('Y');

        $count = $ActionByUserWeek->find('all', array(
            'conditions' => $conditions
        ));

        if($count) {
            //update the current count
            $conditions['id'] = $count[0]['ActionByUserWeek']['id'];
            $total = $count[0]['ActionByUserWeek']['total'];
            $total++;
            $conditions['total'] = $total;
            $ActionByUserWeek->save($conditions);
        }else{
            //start a new count
            $conditions['total'] = 1;
            $ActionByUserWeek->save($conditions);
        }
    }

    /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function updateMonthAggregation($data) {
        $ActionByUserMonth = new ActionByUserMonth();
        $conditions = $this->getConditions($data);
        $time = new DateTime(date($ActionByUserMonth->dateFormat, $data['Action']['time']));
        //TODO - localise times: $time->setTimezone(new DateTimeZone('Pacific/Chatham'));
        $conditions['time'] = $time->format('U');

        $count = $ActionByUserMonth->find('all', array(
            'conditions' => $conditions
        ));

        if($count) {
            //update the current count
            $conditions['id'] = $count[0]['ActionByUserMonth']['id'];
            $total = $count[0]['ActionByUserMonth']['total'];
            $total++;
            $conditions['total'] = $total;
            $ActionByUserMonth->save($conditions);
        }else{
            //start a new count
            $conditions['total'] = 1;
            $ActionByUserMonth->save($conditions);
        }
    }

    /**
     * After save method. Called after all saves
     *
     * @param AppModel $model
     * @param boolean $created indicates whether the node just saved was created or updated
     * @return boolean true on success, false on failure
     * @access public
     */
    public function afterSave($created)
    {
        $this->updateHourAggregation($this->data);
        $this->updateDayAggregation($this->data);
        $this->updateWeekAggregation($this->data);
        $this->updateMonthAggregation($this->data);
        return true;
    }

    public function aggregateUserActions($dateString) {
        return date('Y-m-d', strtotime($dateString));
    }

}
