<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 28/10/12
 * Time: 19:20
 */
App::uses('File', 'Utility');

class CourseProfileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'dynamicForms.dynamicForms');
    public $components = array('Session', 'ProcessData', 'DataFilters');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'Course', 'Person', 'FactSummedActionsDatetime');

    public function index($id = NULL) {

        if($id){
            $this->Session->write('Profile.course', $id);
        }

     //Create selected course as session variable.
        $courseid = $this->Session->read('Profile.course');
        if ($this->request->is('post')) {
            $course = $this->request->data['Action']['courseid'];
            $this->set('courseid', $course);
            $this->set('coursedefault', $course);
            $this->Session->write('Profile.course', $course);
            $this->setCoursePeople($course);
        }elseif($courseid){
        	$selectedcourse = $this->Course->find('first',array(
	        			'conditions' => array('id'=>$courseid),
	        			'contain' => false,
	        		)
        	);
        	$this->set('courseid', $courseid);
            $this->set('course', $selectedcourse);
            $this->set('coursedefault', $selectedcourse['Course']['idnumber']);
            $this->setCoursePeople($courseid);
        }else{
        	$this->set('courseid','');
            $this->set('coursedefault','');
        }
    }

    public function overview() {
    	$courseid = $this->Session->read('Profile.course');
    	if(!$courseid) {
    		$this->Session->setFlash(__('No course selected'));
    		$this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
    	}else{
    		$systems = AppController::get_customerSystems();
    		//Set defaults
	        $period = 'month';
	        $dateWindow = '-2 years';
	        $chartType = 'area';
	        $reportType = 'Activity';
	        $system = array_keys($systems);
	        $width = 750;
	        $height = 500;

    		//Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Overview']['period'];
                $dateWindow = $this->request->data['Overview']['daterange'];
                $chartType = $this->request->data['Overview']['chart'];
                $reportType = $this->request->data['Overview']['report'];
                $system = $this->request->data['Overview']['system'];
                $width = $this->request->data['Overview']['width'];
                $height = $this->request->data['Overview']['height'];
            }

	        $data = array(
	            'title' => $reportType,
	            'type' => $chartType,
	            'width' => $width,
	            'height' => $height
	        );
	        
	        //Set query filters
	        $conditions = $this->DataFilters->returnGroupFilter($system, $courseid);
        	
	        $results = $this->ProcessData->getOverviewData($dateWindow, $period, $conditions);
            $data = array_merge($data,$results);

            $this->set(compact('systems'));

            $this->set('data', $data);
    	}
    }

	public function hourly() {
        $courseid = $this->Session->read('Profile.course');
        if(!$courseid) {
            $this->Session->setFlash(__('No course selected'));
            $this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
        	$dateWindow = '-2 years';
            $report = 'sum';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
            	$dateWindow = $this->request->data['Hourly']['daterange'];
            	$system = $this->request->data['Hourly']['system'];
                //$report = $this->request->data['Hourly']['report'];
                $width = $this->request->data['Hourly']['width'];
                $height = $this->request->data['Hourly']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
	        $conditions = $this->DataFilters->returnGroupFilter($system, $courseid);
        	
	        //Get the data and pass to view
            $dayData = $this->ProcessData->getHourlyData($dateWindow, 'day', $report, $conditions);
            $this->set('dayData', $dayData);

            $nightData = $this->ProcessData->getHourlyData($dateWindow, 'night', $report, $conditions);      
            $this->set('nightData', $nightData);
            
            $this->set(compact('systems'));
        }
    }
    
    public function stream() {
    	$courseid = $this->Session->read('Profile.course');
    	if(!$courseid) {
    		$this->Session->setFlash(__('No course selected'));
    		$this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
    	}else{
    		$systems = AppController::get_customerSystems();
    		
    		//Set defaults.
    		$system = array_keys($systems);
    		$dateWindow = '-3 days';
    		
    		//Update with posted form options if sent.
    		if ($this->request->is('post')) {
    			$dateWindow = $this->request->data['Action']['daterange'];
    			$system = $this->request->data['Action']['system'];
    		}

            //Set query filters
            $conditions = $this->DataFilters->returnGroupFilter($system, $courseid);
            unset($conditions['System.id']);
            $conditions = array_merge($conditions, array(
                    'Action.system_id' => $system,
                    'time >'=>date("Y-m-d", strtotime($dateWindow))
                )
            );
    		
    		//Get action list.
            $cacheName = 'stream.actions.'.$this->formatCacheConditions($conditions);
            $actions = Cache::read($cacheName, 'short');
            if (!$actions) {
                $actions = $this->Action->find('all', array(
                        'contain' => array(
                            'User' => array(
                                'fields' => array(
                                    'User.idnumber'
                                )
                            ),
                            'Group' => array(
                                'fields' => array(
                                    'Group.name',
                                    'Group.idnumber'
                                )
                            ),
                            'DimensionVerb' => array(
                                'Artefact' => array(
                                    'fields' => array('name'),
                                ),
                                'fields' => array(
                                    'DimensionVerb.sysname'
                                )
                            )
                        ),
                        'conditions' => $conditions,
                        'order' => array('time' => 'DESC')
                    )
                );
                Cache::write($cacheName, $actions, 'short');
            }
    		$this->set('actions', $actions);
    		$selectedcourse = $this->Course->find('first',array(
    				'conditions' => array('Course.id'=>$courseid), //array of conditions
    				'contain' => false, //int
    				'fields' => array('idnumber'), //array of field names
    		)
    		);
    		$this->set('courseid',  $selectedcourse['Course']['idnumber']);
    		$this->set(compact('systems'));
    	}    
    }
    

    public function location() {
    	$courseid = $this->Session->read('Profile.course');
    	if(!$courseid) {
    		$this->Session->setFlash(__('No course selected'));
    		$this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
    	}else{
    		$systems = AppController::get_customerSystems();
    		//Set defaults
    		$system = array_keys($systems);
        	$rule = 1;
    		$dateWindow = '-2 years';
    		$period = 'month';
    		$chartType = 'column';
    		$reportType = 'Activity';
    		$width = 750;
    		$height = 500;
    	
    		//Overwrite defaults if form submitted.
    		if ($this->request->is('post')) {
    			$period = $this->request->data['Location']['period'];
    			$dateWindow = $this->request->data['Location']['daterange'];
    			$system = $this->request->data['Location']['system'];
    			$rule = $this->request->data['Location']['rule'];
    			$chartType = $this->request->data['Location']['chart'];
    			//$reportType = $this->request->data['Location']['report'];
    			$width = $this->request->data['Location']['width'];
    			$height = $this->request->data['Location']['height'];
    		}
    	
    		$data = array(
    				'title' => $reportType,
    				'type' => $chartType,
    				'width' => $width,
    				'height' => $height
    		);
    		if($chartType == ('bar' || 'column')) {
    			$data['isStacked'] = true;
    		}
    		
    		//Set query filters
    		$conditions = $this->DataFilters->returnGroupFilter($system, $courseid);
    		 
    		$results = $this->ProcessData->getIPData($dateWindow, $period, $conditions, $chartType);
    		$data = array_merge($data,$results);
    	
    		$this->set('data', $data);
    		$this->set(compact('systems'));
    	}

    }

    public function help() {
    
    }
    
    
	public function modules() {
        $courseid = $this->Session->read('Profile.course');
        if(!$courseid) {
            $this->Session->setFlash(__('No course selected'));
            $this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
        	$dateWindow = '-2 years';
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                //$reportType = $this->request->data['Modules']['report'];
                $dateWindow = $this->request->data['Modules']['daterange'];
                $system = $this->request->data['Modules']['system'];
                $width = $this->request->data['Modules']['width'];
                $height = $this->request->data['Modules']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
            $conditions = $this->DataFilters->returnGroupFilter($system, $courseid);
             
            $this->set('data', $this->ProcessData->getModuleData($dateWindow, $conditions));

            $this->set(compact('systems'));
        }
    }

    public function tasktype() {
        $courseid = $this->Session->read('Profile.course');
        if(!$courseid) {
            $this->Session->setFlash(__('No course selected'));
            $this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
        }else{
        	$systems = $this->get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
            $rule = 1;
        	$dateWindow = '-2 years';
            $period = 'month';
            $chartType = 'column';
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $rule = $this->request->data['TaskType']['rule'];
                $period = $this->request->data['TaskType']['period'];
                $dateWindow = $this->request->data['TaskType']['daterange'];
                $system = $this->request->data['TaskType']['system'];
                $chartType = $this->request->data['TaskType']['chart'];
                $width = $this->request->data['TaskType']['width'];
                $height = $this->request->data['TaskType']['height'];
            }

            $data = array(
                'title' => $reportType,
                'type' => $chartType,
                'width' => $width,
                'height' => $height
            );
            if($chartType == ('bar' || 'column')) {
                $data['isStacked'] = true;
            }
            
            //Set query filters
            $conditions = $this->DataFilters->returnGroupFilter($system, $courseid);
             
            $results = $this->ProcessData->getTaskTypeData($dateWindow, $period, $rule, $conditions, $chartType);
            $data = array_merge($data,$results);

            $this->set('data', $data);
            
            $rules = $this->getCustomerRules();
            $this->set(compact('systems', 'rules'));
        }
    }

    private function getCoursePeople($courseid) {
        $cacheName = 'course_people.'.$courseid;
        $people = Cache::read($cacheName, 'short');
        if (!$people) {
            $people = $this->Course->find('all', array(
                    'contain' => array(
                        'Person' => array(
                            'fields' => array(
                                'Person.id',
                                'Person.idnumber'
                            ),

                        )
                    ),
                    'conditions' => array(
                        'Course.id' => $courseid
                    ),
                )
            );
            Cache::write($cacheName, $people, 'short');
        }
        return Set::extract('/Person/.', $people);
    }

    private function setCoursePeople($courseid) {
        $people = $this->getCoursePeople($courseid);

        $begin = new DateTime( date('Y-m-d', strtotime("-3 weeks", time())));
        $end = new DateTime( date('Y-m-d', strtotime("+1 weeks", time())) );
        // Get years as range.
        $interval = new DateInterval('P1W');
        $daterange = new DatePeriod($begin, $interval, $end);

        $this->set('daterange', $daterange);
        $i = 0;
        foreach ($people as $person) {
            $cacheName = 'course_people_person'.$person['id'];
            $users = Cache::read($cacheName, 'short');
            if (!$users) {
                $users = $this->Person->User->find('all',array(
                        'contain' => array(
                            'Person' => array(
                                'fields' => array(
                                    'Person.id'
                                )
                            )
                        ),
                        'conditions' => array('Person.id' => $person['id']),
                        'fields' => array('User.id')
                    )
                );
                Cache::write($cacheName, $users, 'short');
            }
            $users = Set::extract('/User/id', $users);
            foreach ($daterange as $date) {
                $conditions = array(
                    'user_id' => $users,
                    'DimensionDate.week_starting_monday' => $date->format("W")
                );
                $cacheName = 'course_people_date.'.$this->formatCacheConditions($conditions);
                $value = Cache::read($cacheName, 'short');
                if (!$value) {
                    $value = $this->FactSummedActionsDatetime->find('first', array(
                            'conditions' => $conditions,
                            'contain' => array(
                                'DimensionDate' => array(
                                    'fields' => array(
                                        'DimensionDate.date'
                                    )
                                ),
                                'System' => array(
                                    'fields' => array(
                                        'System.id'
                                    )
                                )
                            ),
                            'fields' => "SUM(FactSummedActionsDatetime.total) as total", //array of field names
                        )
                    );
                    Cache::write($cacheName, $value, 'short');
                }
                if($value[0]['total']) {
                    $people[$i]['week'][$date->format("W")] = $value[0]['total'];
                }else{
                    $people[$i]['week'][$date->format("W")] = '0';
                }
            }
            $i++;
        }

        return $this->set('people', $people);
    }
}



