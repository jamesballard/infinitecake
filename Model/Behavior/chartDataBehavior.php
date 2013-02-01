<?php
App::uses('Artefact', 'Model');
/**
 * GChart behavior
 *
 * Returns Academic Year data in an array that can be passed to Google Chart
 *
 * @package       Cake.Model.Behavior
 * @link
 */
class chartDataBehavior extends ModelBehavior {

/**
 * Flattens array results to GChart format
 *
 * @param array $results Data return
 * @param boolean $primary Using primary key
 * @return array $data Transformed array for Google Chart Period => Year 1 Count => Year 2 Count ... Year n count
 */
    public function transformGchartArray(Model $Model, $results, $primary = false) {
        $i = 1;
        $data = array();
        $data['labels'][] = array('string' => 'Period');
        foreach ($results as $year=>$period) {
            $data['labels'][] = array('number' => $year);
            $n = 0;
            foreach ($period as $pair) {
                foreach($pair as $key=>$value) {
                    $data['data'][$n][0] = $key;
                    $data['data'][$n][$i] = $value;
                }
                $n++;
            }
            $i++;
        }
        return $data;
    }

/**
 * Flattens array results to GChart pie chart format
 *
 * @param array $results Data return
 * @param boolean $primary Using primary key
 * @return array $data Transformed array for Google Chart Period => Year 1 Count => Year 2 Count ... Year n count
 */
    public function transformPiechartArray(Model $Model, $results, $primary = false) {
    	$i = 1;
    	$data = array();
    	$data['labels'][] = array('string' => 'Condition');
    	$data['labels'][] = array('number' => $condition);
        foreach ($results as $condition=>$count) {
        	$data['data'][$n][0] = $condition;
            $data['data'][$n][$i] = $count;
            $i++;
        }
    	return $data;
    }
/**
 * Flattens array results to Google Treemap format
 *
 * @param array $results Data return
 * @param boolean $primary Using primary key
 * @return array $data Transformed array for Google Chart Period => Year 1 Count => Year 2 Count ... Year n count
 */
    public function transformModuleTreemap(Model $Model, $results, $primary = false) {
        $i = 2;
        $data = array();
        $data['labels'][] = array('string' => 'Module');
        $data['labels'][] = array('string' => 'Type');
        $Artefact = new Artefact();
        $modules = $Artefact->getArtefacts();
        foreach ($results as $year=>$period) {
            $data['labels'][] = array('number' => $year);
            $n = 0;
            foreach ($period as $pair) {
                foreach($pair as $key=>$value) {
                    $data['data'][$n][0] = $key;
                    $type = $Artefact->find('first', array(
                                            'fields' => array('type'),
                                            'recursive' => -1,
                                            'conditions' => array('name' => $key)
                                            ));
                    switch($type['Artefact']['type']) {
                        case Artefact::ARTEFACT_TYPE_ASSESSMENT:
                            $data['data'][$n][1] = 'Assessment';
                            break;
                        case Artefact::ARTEFACT_TYPE_COLLABORATION:
                            $data['data'][$n][1] = 'Collaboration';
                            break;
                        case Artefact::ARTEFACT_TYPE_COMMUNICATION:
                            $data['data'][$n][1] = 'Communication';
                            break;
                        case Artefact::ARTEFACT_TYPE_RESOURCE:
                            $data['data'][$n][1] = 'Resource';
                            break;
                    }
                    $data['data'][$n][$i] = $value;
                }
                $n++;
            }
            $i++;
        }
        return $data;
    }


}
