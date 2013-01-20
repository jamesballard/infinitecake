<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 28/10/12
 * Time: 19:20
 */
App::uses('File', 'Utility');

class CourseprofileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'autoComplete.autoCompleteRemote');
    public $components = array('Session', 'ProcessData', 'DataFilters');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'Group');

    public function index() {
     //Create selected group as session variable.            
        $groupid = $this->Session->read('Profile.group');
        if ($this->request->is('post')) {
            $group = $this->request->data['Action']['groupid'];
            $this->set('groupid', $group);
            $this->set('groupdefault', $group);
            $this->Session->write('Profile.group', $group);
        }elseif($groupid){
        	$selectedgroup = $this->Group->find('first',array(
	        			'conditions' => array('id'=>$groupid), //array of conditions
	        			'contain' => false, //int
	        			'fields' => array('idnumber'), //array of field names
	        		)
        	);
        	$this->set('groupid', $groupid);
            $this->set('groupdefault', $selectedgroup['Group']['idnumber']);
        }else{
        	$this->set('groupid','');
            $this->set('groupdefault','');
        }
    }

    public function overview() {
    	$groupid = $this->Session->read('Profile.group');
    	if(!$groupid) {
    		$this->Session->setFlash(__('No group selected'));
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
                $period = $this->request->data['Action']['period'];
                $dateWindow = $this->request->data['Action']['daterange'];
                $chartType = $this->request->data['Action']['chart'];
                $reportType = $this->request->data['Action']['report'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

	        $data = array(
	            'title' => $reportType,
	            'type' => $chartType,
	            'width' => $width,
	            'height' => $height
	        );
	        
	        //Set query filters
	        $conditions = $this->DataFilters->returnGroupFilter($system, $groupid);
        	
	        $results = $this->ProcessData->getOverviewData($dateWindow, $period, $conditions);
            $data = array_merge($data,$results);

            $this->set(compact('systems'));

            $this->set('data', $data);
    	}
    }

	public function hourly() {
        $groupid = $this->Session->read('Profile.group');
        if(!$groupid) {
            $this->Session->setFlash(__('No group selected'));
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
            	$dateWindow = $this->request->data['Action']['daterange'];
            	$system = $this->request->data['Action']['system'];
                //$report = $this->request->data['Action']['report'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
	        $conditions = $this->DataFilters->returnGroupFilter($system, $groupid);
        	
	        //Get the data and pass to view
            $dayData = $this->ProcessData->getHourlyData($dateWindow, 'day', $report, $conditions);
            $this->set('dayData', $dayData);

            $nightData = $this->ProcessData->getHourlyData($dateWindow, 'night', $report, $conditions);      
            $this->set('nightData', $nightData);
            
            $this->set(compact('systems'));
        }
    }
    
    public function stream() {
    	$groupid = $this->Session->read('Profile.group');
    	if(!$groupid) {
    		$this->Session->setFlash(__('No user selected'));
    		$this->redirect(array('controller' => 'Userprofile', 'action' => ''));
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
    		
    		//Get action list.
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
    				'conditions' => array('Action.group_id' => $groupid, 
    						'Action.system_id' => $system,
    						'time >'=>date("Y-m-d", strtotime($dateWindow))
    						),
    				'order' => array('time' => 'DESC')
    				)
    			);
    		$this->set('actions', $actions);
    		$selectedgroup = $this->Group->find('first',array(
    				'conditions' => array('Group.id'=>$groupid), //array of conditions
    				'contain' => false, //int
    				'fields' => array('idnumber'), //array of field names
    		)
    		);
    		$this->set('groupid',  $selectedgroup['Group']['idnumber']);
    		$this->set(compact('systems'));
    	}    
    }
    

    public function location() {
    	$groupid = $this->Session->read('Profile.group');
    	if(!$groupid) {
    		$this->Session->setFlash(__('No group selected'));
    		$this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
    	}else{
    		$systems = AppController::get_customerSystems();
    		//Set defaults
    		$system = array_keys($systems);
    		$dateWindow = '-2 years';
    		$period = 'month';
    		$chartType = 'column';
    		$reportType = 'Activity';
    		$width = 750;
    		$height = 500;
    	
    		//Overwrite defaults if form submitted.
    		if ($this->request->is('post')) {
    			$period = $this->request->data['Action']['period'];
    			$dateWindow = $this->request->data['Action']['daterange'];
    			$system = $this->request->data['Action']['system'];
    			$chartType = $this->request->data['Action']['chart'];
    			//$reportType = $this->request->data['Action']['report'];
    			$width = $this->request->data['Action']['width'];
    			$height = $this->request->data['Action']['height'];
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
    		$conditions = $this->DataFilters->returnGroupFilter($system, $groupid);
    		 
    		$results = $this->ProcessData->getIPData($dateWindow, $period, $conditions);
    		$data = array_merge($data,$results);
    	
    		$this->set('data', $data);
    		$this->set(compact('systems'));
    	}

    }

    public function help() {
    
    }
    
    
	public function modules() {
        $groupid = $this->Session->read('Profile.group');
        if(!$groupid) {
            $this->Session->setFlash(__('No group selected'));
            $this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
        	$dateWindow = '-2 years';
            $reportType = 'Activity';
            $system = 0;
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                //$reportType = $this->request->data['Action']['report'];
                $dateWindow = $this->request->data['Action']['daterange'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
            $conditions = $this->DataFilters->returnGroupFilter($system, $groupid);
             
            $this->set('data', $this->ProcessData->getModuleData($dateWindow, $conditions));

            $this->set(compact('systems'));
        }
    }

    public function tasktype() {
        $groupid = $this->Session->read('Profile.group');
        if(!$groupid) {
            $this->Session->setFlash(__('No group selected'));
            $this->redirect(array('controller' => 'Courseprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
        	$dateWindow = '-2 years';
            $period = 'month';
            $chartType = 'column';
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Action']['period'];
                $dateWindow = $this->request->data['Action']['daterange'];
                $system = $this->request->data['Action']['system'];
                $chartType = $this->request->data['Action']['chart'];
                //$reportType = $this->request->data['Action']['report'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
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
            $conditions = $this->DataFilters->returnGroupFilter($system, $groupid);
             
            $results = $this->ProcessData->getTaskTypeData($dateWindow, $period, $conditions);
            $data = array_merge($data,$results);

            $this->set('data', $data);
            $this->set(compact('systems'));
        }
    }
}



