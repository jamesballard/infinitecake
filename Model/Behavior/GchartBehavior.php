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

    // Define the modules used for reports
    public function getModules (Model $Model) {
        return array(
            'assignment' => 'Assessment',
            'blog' => 'Communication',
            'book' => 'Resource',
            'chat' => 'Communciation',
            'choice' => 'Assessment',
            'data' => 'Collaboration',
            'feedback' => 'Assessment',
            'folder' => 'Resource',
            'forum' => 'Communication',
            'glossary' => 'Collaboration',
            'imscp' => 'Resource',
            'label' => 'Resource',
            'lesson' => 'Assessment',
            'lightboxgallery' => 'Resource',
            'message' => 'Communication',
            'nln' => 'Resource',
            'page' => 'Resource',
            'quiz' => 'Assessment',
            'resource' => 'Resource',
            'scorm' => 'Resource',
            'url' => 'Resource',
            'wiki' => 'Collaboration'
        );
    }

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
        $modules = $this->getModules($Model);
        foreach ($results as $year=>$period) {
            $data['labels'][] = array('number' => $year);
            $n = 0;
            foreach ($period as $pair) {
                foreach($pair as $key=>$value) {
                    $data['data'][$n][0] = $key;
                    $data['data'][$n][1] = $modules[$key];
                    $data['data'][$n][$i] = $value;
                }
                $n++;
            }
            $i++;
        }
        return $data;
    }


}
