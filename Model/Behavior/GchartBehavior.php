<?php
/**
 * GChart behavior
 *
 * Returns Academic Year data in an array that can be passed to Google Chart
 *
 * @package       Cake.Model.Behavior
 * @link
 */
class GchartBehavior extends ModelBehavior {

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
}
