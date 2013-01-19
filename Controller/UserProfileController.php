<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 21:37
 */
class UserprofileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'autoComplete.autoCompleteRemote');
    public $components = array('Session', 'ProcessData', 'DataFilters');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'Person', 'User');

    public function index() {
        //Create selected user as session variable.            
        $userid = $this->Session->read('Profile.user');
        if ($this->request->is('post')) {
            $user = $this->request->data['Action']['userid'];
            $this->set('userid', $user);
            $this->set('userdefault', $user);
            $this->Session->write('Profile.user', $user);
        }elseif($userid){
        	$selecteduser = $this->Person->find('first',array(
	        			'conditions' => array('id'=>$userid), //array of conditions
	        			'contain' => false, //int
	        			'fields' => array('idnumber'), //array of field names
	        		)
        	);
        	$this->set('userid', $userid);
            $this->set('userdefault', $selecteduser['Person']['idnumber']);
        }else{
        	$this->set('userid','');
            $this->set('userdefault','');
        }
    }

    public function overview() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
            $period = 'month';
            $chartType = 'area';
            $reportType = 'Activity';
            $system = array_keys($systems);
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Action']['period'];
                $chartType = $this->request->data['Action']['chart'];
                $reportType = $this->request->data['Action']['report'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }
			
            //Configure the data array
            $data = array(
                'title' => $reportType,
                'type' => $chartType,
                'width' => $width,
                'height' => $height
            );

            //Set query filters
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            //Get and merge data 
            $results = $this->ProcessData->getOverviewData($period, $conditions);
            $data = array_merge($data,$results);
			
            //Send to view
            $this->set(compact('systems'));
            $this->set('data', $data);
        }
    }

    public function location() {
    	$userid = $this->Session->read('Profile.user');
    	if(!$userid) {
    		$this->Session->setFlash(__('No user selected'));
    		$this->redirect(array('controller' => 'Userprofile', 'action' => ''));
    	}else{
    		$systems = AppController::get_customerSystems();
    		//Set defaults
    		$system = array_keys($systems);
    		$period = 'month';
    		$chartType = 'column';
    		$reportType = 'Activity';
    		$width = 750;
    		$height = 500;
    	
    		//Overwrite defaults if form submitted.
    		if ($this->request->is('post')) {
    			$period = $this->request->data['Action']['period'];
    			$system = $this->request->data['Action']['system'];
    			$chartType = $this->request->data['Action']['chart'];
    			$reportType = $this->request->data['Action']['report'];
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
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            //Get and merge data 
            $results = $this->ProcessData->getIPData($period, $conditions);
    		$data = array_merge($data,$results);
    	
    		$this->set('data', $data);
    		$this->set(compact('systems'));
    	}
    }
    
    public function stream() {
    	$userid = $this->Session->read('Profile.user');
    	if(!$userid) {
    		$this->Session->setFlash(__('No user selected'));
    		$this->redirect(array('controller' => 'Userprofile', 'action' => ''));
    	}else{
    		$systems = AppController::get_customerSystems();
    		//Set defaults
    		$system = array_keys($systems);
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
    				'conditions' => array('user_id' => $userid, 
    						'Action.system_id' => $system, 
    						'time >'=>date("Y-m-d", strtotime('-6 months'))
    						),
    				'order' => array('time' => 'DESC')
    				)
    			);
    		$this->set('actions', $actions);
    		$selecteduser = $this->Person->find('first',array(
    				'conditions' => array('id'=>$userid), //array of conditions
    				'contain' => false, //int
    				'fields' => array('idnumber'), //array of field names
    		)
    		);
    		$this->set('userid',  $selecteduser['Person']['idnumber']);
    		$this->set(compact('systems'));
    	}    
    }
    
    public function help() {
    
    }

    public function hourly() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
            $report = 'sum';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
            	$system = $this->request->data['Action']['system'];
                $report = $this->request->data['Action']['report'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);

            //Set query filters
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            $dayData = $this->ProcessData->getHourlyData('day', $report, $conditions);

            $this->set('dayData', $dayData);

            $nightData = $this->ProcessData->getHourlyData('night', $report, $conditions);

            $this->set('nightData', $nightData);
            $this->set(compact('systems'));
        }
    }

    public function modules() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
            $reportType = 'Activity';
            $system = array_keys($systems);
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $reportType = $this->request->data['Action']['report'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            $this->set('data', $this->ProcessData->getModuleData($conditions));

            $this->set(compact('systems'));
        }
    }

    public function tasktype() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
        }else{
        	$systems = AppController::get_customerSystems();
            //Set defaults
        	$system = array_keys($systems);
            $period = 'month';
            $chartType = 'column';
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Action']['period'];
                $system = $this->request->data['Action']['system'];
                $chartType = $this->request->data['Action']['chart'];
                $reportType = $this->request->data['Action']['report'];
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
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            $results = $this->ProcessData->getTaskTypeData($period, $conditions);
            $data = array_merge($data,$results);

            $this->set('data', $data);
            $this->set(compact('systems'));
        }
    }
}
