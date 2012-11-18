<?php
App::uses('ActionByUserDay', 'Model');
App::uses('ActionByUserHour', 'Model');
App::uses('ActionByUserMonth', 'Model');
App::uses('ActionByUserWeek', 'Model');
/**
 * Aggregatable Behavior (updates real aggregators of foreign Model)
 *
 */
class AggregateableBehavior extends ModelBehavior {

    /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function getData(&$model) {
        $data = array(
            'user'=>$model->data['Action']['user'],
            'group'=>$model->data['Action']['group'],
            'artefact'=>$model->data['Action']['artefact'],
            'action'=>$model->data['Action']['name'],
        );

    }


     /**
     * Choose models to be updated
     *
     * @param AppModel &$model
     * @return boolean success
     * @access public
     */
    function updateHourAggregation(&$model) {





        $ActionByUserHour = new ActionByUserHour();
        $ActionByUserDay = new ActionByUserDay();
        $ActionByUserWeek = new ActionByUserWeek();
        $ActionByUserMonth = new ActionByUserMonth();
        $aggrModels = array(
            $ActionByUserHour,
            $ActionByUserDay,
            $ActionByUserWeek,
            $ActionByUserMonth
        );

        foreach($aggrModels as $aggrModel) {
            unset($conditions['hour']);
            unset($conditions['week']);
            unset($conditions['year']);
            $modelName = get_class($aggrModel);
            $time = new DateTime(date($aggrModel->dateFormat, $model->data['Action']['time']));
            //TODO - localise times: $time->setTimezone(new DateTimeZone('Pacific/Chatham'));
            $conditions['time'] = $time->format('U');

            if($modelName == 'ActionByUserHour') {
                $conditions['hour'] = $time->format('G');
            }

            if($modelName == 'ActionByUserWeek') {
                unset($conditions['time']);
                $conditions['week'] = $time->format('W');
                $conditions['year'] = $time->format('Y');
            }

            $count = $aggrModel->find('all', array(
                'conditions' => $conditions
            ));

            if($count) {
                //update the current count
                $conditions['id'] = (int)$count[0][$modelName]['id'];
                $total = (int)$count[0][$modelName]['total'];
                $total++;
                $conditions['total'] = $total;
                $aggrModel->save($conditions);
            }else{
                $conditions['total'] = 1;
                //start a new count
                $aggrModel->save($conditions);
            }
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
    function afterSave(&$model, $created)
    {
        return $this->updateTimeAggregation($model);
    }
    /**
     * Before delete method. Called before all deletes
     *
     * @param AppModel $model
     * @return boolean true on success, false on failure
     * @access public
     */
    function afterDelete(&$model)
    {
        return $this->updateRealAggregators($model);
    }
}

?>
