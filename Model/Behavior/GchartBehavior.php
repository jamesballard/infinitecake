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
class GchartBehavior extends ModelBehavior {

    // Define the modules used for reports
    public function getTaskTypes (Model $Model) {
        return array(
            'assimilative' => 'Assimilative',
            'information' => 'Information Handling',
            'adaptive' => 'Adaptive',
            'communicative' => 'Communicative',
            'productive' => 'Productive',
            'experiential' => 'Experiential'
        );
    }


    public function assimilativeActions(Model $Model) {
        return array(
            //'Assignment View' => 'assignment view',
            'Blog View' => 'blog view',
            'Book View' => 'book view',
            'Chat Report' => 'chat_report',
            //'Chat View' => 'chat view',
            //'Choice View' => 'choice view',
            'Data View' => 'data view',
            'Folder View' => 'folder view',
            //'Read Discussion' => 'forum view discussion',
            //'Glossary View' => 'glossary view',
            'View Glossary Entry' => 'glossary view entry',
            //'Hotpot View' => 'hotpot view',
            //'Lesson View' => 'lesson view',
            'Gallery View' => 'lightboxgallery view',
            //'Quiz Preview' => 'quiz preview',
            //'Quiz Review' => 'quiz review',
            //'Quiz View' => 'quiz view',
            'Resource View' => 'resource view',
            'SCORM View' => 'scorm pre-view',
            'SCORM View' => 'scorm view',
            //'User View' => 'user view',
            'Wiki View' => 'wiki view'
        );
    }

    public function informationActions(Model $Model) {
        return array(
            'Data Entry' => 'data add'
        );
    }

    public function adaptiveActions(Model $Model) {
        return array(
        );
    }

    public function productiveActions(Model $Model) {
        return array(
            'Assignment Upload' => 'assignment TII API SUBMISSION',
            'Assignment Upload' => 'assignment upload',
            'Blog Post' => 'blog add',
            //'blog delete',
            //'blog update',
            //'chat add',
            'Choice' => 'choice choose',
            'Change Choice' => 'choice choose again',
            'Glossary Entry' => 'glossary add entry',
            'Hotpot Quiz' => 'hotpot submit',
            'Complete Lesson' => 'lesson end',
            //'Start Lesson' => 'lesson start',
            'Attempt Quiz' => 'quiz attempt',
            'Finish Quiz' => 'quiz close attempt',
            //'quiz continue attemp',
            //'Update Profile' => 'user update',
            'Edit Wiki' => 'wiki edit'
        );
    }

    public function communicativeActions(Model $Model) {
        return array(
            'Chat' => 'chat talk',
            'Forum Discussion' => 'forum add discussion',
            'Forum Post' => 'forum add post',
            //'forum delete discussion',
            //'forum delete post',
            //'forum view forum',
            'Gloassary Comment' => 'glossary add comment',
            'Gallery Comment' => 'lightboxgallery comment',
            //'message add contact',
            //'message block contact',
            //'message remove contact',
            //'message unblock contact',
            'Instant Message' => 'message write'
        );
    }

    public function experientialActions(Model $Model) {
        return array(
        );
    }

    function getActions(Model $Model) {
        return array_merge($this->assimilativeActions(),$this->productiveActions(),$this->informationActions(),$this->communicativeActions());
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
