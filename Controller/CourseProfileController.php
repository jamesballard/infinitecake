<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 28/10/12
 * Time: 19:20
 */
App::uses('File', 'Utility');

class CourseprofileController extends AppController {
    public $helpers = array('Html', 'Form', 'Session', 'GChart.GChart', 'DrasticTreeMap.DrasticTreeMap');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('MdlCourseCategories', 'MdlCourse', 'MdlLog');

    // Define the modules used for reports
    private $modules = array(
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

    public function index() {

    }

    public function overview() {
        //Set defaults
        $period = 'month';
        $chartType = 'area';
        $reportType = 'Activity';
        $width = 750;
        $height = 500;

        //Overwrite defaults if form submitted.
        if ($this->request->is('post')) {
            $period = $this->request->data['MdlCourseCategories']['period'];
            $chartType = $this->request->data['MdlCourseCategories']['chart'];
            $reportType = $this->request->data['MdlCourseCategories']['report'];
            $width = $this->request->data['MdlCourseCategories']['width'];
            $height = $this->request->data['MdlCourseCategories']['height'];
        }

        $data = array(
            'title' => $reportType,
            'type' => $chartType,
            'width' => $width,
            'height' => $height
        );
        $results = $this->getData($period, $reportType);
        $data = array_merge($data,$results);

        $this->set('data', $data);

    }

    public function location() {

    }

    public function modules() {

    }

    public function tasktype() {

    }

    /**
     * Contructs and returns appropriate data.
     *
     * @param integer $period Determines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getData($period, $reportType) {
        $data = $this->MdlLog->getPeriodCountGchart($period, $reportType, array('course'=>'4430'));
        return $data;
    }

    public function createfile() {
        $this->writeActivityData();
    }

    private function writeActivityData() {

        //TODO: File should be treated as cache in some way
        //$result = Cache::read('ActivityFile', 'long');
        //if (!$result) {
            // Create a new file
            $file = new File('data/myactivity2.tsv', true);
            $file->delete();
            $file->create();
            $delimiter = "\t";

            //Write the header row
            $titleArray = array('Subject', 'Module', 'Type', 'Total', 'Users', 'Views', 'Contributions');
            $titleString = implode($delimiter, $titleArray);
            $filedata = $titleString . "\n";
            $file->append($filedata);

            // Get the selected set of 'subject' categories
            $categories = $this->getTopLevelCategories();

            foreach ($categories as $category) {
                $categoryids = array($category['MdlCourseCategories']['id']);

                // Get all sub-level categories
                $subcats = $this->getSubLevelCategories($category['MdlCourseCategories']['id']);

                foreach ($subcats as $subcat) {
                    $categoryids[] = $subcat['MdlCourseCategories']['id'];
                }

                //Iterate through modules to get count of each per category
                foreach ($this->modules as $module=>$type) {
                    $datarow = array();
                    $datarow[] = trim($category['MdlCourseCategories']['name']);
                    $datarow[] = ucfirst($module);
                    $datarow[] = $type;
                    $datarow[] = $this->getTotal($module,$categoryids);
                    $datarow[] = $this->getUsers($module,$categoryids);
                    $datarow[] = $this->getViews($module,$categoryids);
                    $datarow[] = $this->getContributions($module,$categoryids);

                    $dataRowString = implode($delimiter, $datarow);
                    $filedata = $dataRowString . "\n";
                    $file->append($filedata);
                }
            }
            //Cache::write('ActivityFile','true','long');
        //}
    }

    private function getTopLevelCategories($depth=1) {
        $result = Cache::read('originalCategories'.$depth, 'long');
        if (!$result) {
            $params = array(
                //TODO: hard-coded category filter should be configurable
                'conditions' => array('MdlCourseCategories.id' => array(6,7,9,12,13,15,16,19,25,27,28,87,180,284)), //array of conditions
                'fields' => array('id','name','idnumber'), //array of field names
                'callbacks' => true //other possible values are false, 'before', 'after'
            );
            $result = $this->MdlCourseCategories->find('all',$params);
            Cache::write('originalCategories'.$depth, $result, 'long');
        }
        return $result;
    }

    private function getSubLevelCategories($categoryID) {
        $result = Cache::read('subCategories'.$categoryID, 'long');
        if (!$result) {
            $params = array(
                'conditions' => array('MdlCourseCategories.path LIKE' => "/$categoryID/%"), //array of conditions
                'fields' => array('id'), //array of field names
                'callbacks' => true //other possible values are false, 'before', 'after'
            );
            $result = $this->MdlCourseCategories->find('all',$params);
            Cache::write('subCategories'.$categoryID, $result, 'long');
        }
        return $result;
    }

    private function getCoursesInCategory($categories) {
        $result = Cache::read('courseCategories'.implode('',$categories), 'long');
        if (!$result) {
            $params = array(
                'conditions' => array('MdlCourse.category' => $categories), //array of conditions
                'fields' => array('id'), //array of field names
                'callbacks' => true //other possible values are false, 'before', 'after'
            );
            $result = $this->MdlCourse->find('all',$params);
            Cache::write('courseCategories'.implode('',$categories), $result, 'long');
        }
        return $result;
    }

    private function getTotal($module,$categories) {
        $totalCount = Cache::read('total'.$module.implode('',$categories), 'long');
        if (!$totalCount) {
            $courses = $this->getCoursesInCategory($categories);
            $totals = array();
            foreach ($courses as $course) {
                $params = array(
                    'conditions' => array('MdlLog.module' => $module, 'MdlLog.course' => $course['MdlCourse']['id']), //array of conditions
                    'callbacks' => true //other possible values are false, 'before', 'after'
                );
                $result = Cache::read('total'.$module.$course['MdlCourse']['id'], 'long');
                if (!$result) {
                    $result = $this->MdlLog->find('count',$params);
                    Cache::write('total'.$module.$course['MdlCourse']['id'], $result, 'long');
                }
                $totals[] = $result;
            }
            $totalCount = array_sum($totals);
            Cache::write('total'.$module.implode('',$categories), $totalCount, 'long');
        }
        return $totalCount;
    }

    private function getUsers($module,$categories) {
        $usersCount = Cache::read('users'.$module.implode('',$categories), 'long');
        if (!$usersCount) {
            $courses = $this->getCoursesInCategory($categories);
            $users = array();
            foreach ($courses as $course) {
                $params = array(
                    'conditions' => array('MdlLog.module' => $module, 'MdlLog.course' => $course['MdlCourse']['id']), //array of conditions
                    'fields' => array('DISTINCT userid'), //array of field names
                    'callbacks' => true //other possible values are false, 'before', 'after'
                );

                $result = Cache::read('users'.$module.$course['MdlCourse']['id'], 'long');
                if (!$result) {
                    $result = $this->MdlLog->find('count',$params);
                    Cache::write('users'.$module.$course['MdlCourse']['id'], $result, 'long');
                }
                $users[] = $result;
            }
            $usersCount = array_sum($users);
            Cache::write('users'.$module.implode('',$categories), $usersCount, 'long');
        }
        return $usersCount;
    }

    private function getViews($module,$categories) {
        $viewsCount = Cache::read('views'.$module.implode('',$categories), 'long');
        if (!$viewsCount) {
            $courses = $this->getCoursesInCategory($categories);
            $views = array();
            $actions = $this->getModuleViewActions($module);
            if($actions){
                foreach ($courses as $course) {
                    foreach ($actions as $action) {
                        $params = array(
                            'conditions' => array('MdlLog.module' => $module, 'MdlLog.course' => $course['MdlCourse']['id'],
                                'MdlLog.action' => $action),
                            'callbacks' => true //other possible values are false, 'before', 'after'
                        );

                        $result = Cache::read('views'.$module.$course['MdlCourse']['id'].$action, 'long');
                        if (!$result) {
                            $result = $this->MdlLog->find('count',$params);
                            Cache::write('views'.$module.$course['MdlCourse']['id'].$action, $result, 'long');
                        }
                        $views[] = $result;
                    }
                }
            }

            $viewsCount = array_sum($views);
            Cache::write('views'.$module.implode('',$categories), $viewsCount, 'long');
        }
        return $viewsCount;
    }

    private function getContributions($module,$categories) {
        $contribCount = Cache::read('contribs'.$module.implode('',$categories), 'long');
        if (!$contribCount) {
            $courses = $this->getCoursesInCategory($categories);
            $contribs = array();
            $actions = $this->getModuleContribActions($module);
            if($actions){
                foreach ($courses as $course) {
                    foreach ($actions as $action) {
                        $params = array(
                            'conditions' => array('MdlLog.module' => $module, 'MdlLog.course' => $course['MdlCourse']['id'],
                                'MdlLog.action' => $action),
                            'callbacks' => true //other possible values are false, 'before', 'after'
                        );

                        $result = Cache::read('contribs'.$module.$course['MdlCourse']['id'].$action, 'long');
                        if (!$result) {
                            $result = $this->MdlLog->find('count',$params);
                            Cache::write('contribs'.$module.$course['MdlCourse']['id'].$action, $result, 'long');
                        }
                        $contribs[] = $result;
                    }
                }
            }
            $contribCount = array_sum($contribs);
            Cache::write('contribs'.$module.implode('',$categories), $contribCount, 'long');
        }
        return $contribCount;
    }

    private function getModuleViewActions($module) {
        switch($module) {
            case 'assignment':
                return array('view');
            case 'blog':
                return array('view');
            case 'book':
                return array('view');
            case 'chat':
                return array('view');
            case 'choice':
                return array('view', 'report');
            case 'data':
                return array('view');
            case 'feedback':
                return array('view');
            case 'folder':
                return array('view');
            case 'forum':
                return array('view forum', 'view discussion');
            case 'glossary':
                return array('view', 'view entry');
            case 'imscp':
                return array('view');
            case 'label':
                return array('view');
            case 'lesson':
                return array('view', 'view grade');
            case 'lightboxgallery':
                return array('view');
            case 'message':
                return array('history');
            case 'nln':
                return array('view');
            case 'page':
                return array('view');
            case 'quiz':
                return array('view', 'review', 'preview');
            case 'resource':
                return array('view');
            case 'scorm':
                return array('view', 'pre-view');
            case 'url':
                return array('view');
            case 'wiki':
                return array('view', 'history');
        }
    }

    private function getModuleContribActions($module) {
        switch($module) {
            case 'assignment':
                return array('TII API SUBMISSION', 'upload');
            case 'blog':
                return array('add', 'update');
            case 'book':
                return false;
            case 'chat':
                return array('talk');
            case 'choice':
                return array('choose', 'choose again');
            case 'data':
                return array('add');
            case 'feedback':
                return array('submit');
            case 'folder':
                return false;
            case 'forum':
                return array('add post', 'add discussion', 'update post');
            case 'glossary':
                return array('add comment', 'add entry', 'update comment', 'update entry');
            case 'imscp':
                return false;
            case 'label':
                return false;
            case 'lesson':
                return array('start', 'end');
            case 'lightboxgallery':
                return array('comment');
            case 'message':
                return array('write');
            case 'nln':
                return false;
            case 'page':
                return false;
            case 'quiz':
                return array('attempt', 'close attempt', 'continue attempt');
            case 'resource':
                return false;
            case 'scorm':
                return array('launch');
            case 'url':
                return false;
            case 'wiki':
                return array('edit');
        }
    }
}



