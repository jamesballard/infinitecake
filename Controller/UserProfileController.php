<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/11/12
 * Time: 21:37
 */
class UserProfileController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'dynamicForms.dynamicForms');
    public $components = array('Session', 'ProcessData', 'DataFilters');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'Person', 'User');

    public function index($id = NULL) {

        if($id){
            $this->Session->write('Profile.user', $id);
        }

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
            $results = $this->ProcessData->getOverviewData($dateWindow, $period, $conditions);
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
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            //Get and merge data 
            $results = $this->ProcessData->getIPData($dateWindow, $period, $conditions, $chartType);
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
    	
    		//Set defaults.
    		$system = array_keys($systems);
    		$dateWindow = '-3 days';
    		
    		//Update with posted form options if sent.
    		if ($this->request->is('post')) {
    			$dateWindow = $this->request->data['Action']['daterange'];
    			$system = $this->request->data['Action']['system'];
    		}
    		
    		//Get action list.
            $conditions = array('user_id' => $userid,
                'Action.system_id' => $system,
                'time >'=>date("Y-m-d", strtotime($dateWindow))
            );
            $cacheName = 'stream_actions.'.$this->formatCacheConditions($conditions);
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
        	$dateWindow = '-2 years';
            $report = 'sum';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
            	$system = $this->request->data['Hourly']['system'];
            	$dateWindow = $this->request->data['Hourly']['daterange'];
                //$report = $this->request->data['Hourly']['report'];
                $width = $this->request->data['Hourly']['width'];
                $height = $this->request->data['Hourly']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);

            //Set query filters
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            $dayData = $this->ProcessData->getHourlyData($dateWindow, 'day', $report, $conditions);

            $this->set('dayData', $dayData);

            $nightData = $this->ProcessData->getHourlyData($dateWindow, 'night', $report, $conditions);

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
            $dateWindow = '-2 years';
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
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            $this->set('data', $this->ProcessData->getModuleData($dateWindow, $conditions));

            $this->set(compact('systems'));
        }
    }

    public function tasktype() {
        $userid = $this->Session->read('Profile.user');
        if(!$userid) {
            $this->Session->setFlash(__('No user selected'));
            $this->redirect(array('controller' => 'Userprofile', 'action' => ''));
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
                $period = $this->request->data['TaskType']['period'];
                $dateWindow = $this->request->data['TaskType']['daterange'];
                $system = $this->request->data['TaskType']['system'];
                $rule = $this->request->data['TaskType']['rule'];
                $chartType = $this->request->data['TaskType']['chart'];
                //$reportType = $this->request->data['TaskType']['report'];
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
            $conditions = $this->DataFilters->returnPersonFilter($system, $userid);
            
            $results = $this->ProcessData->getTaskTypeData($dateWindow, $period, $rule, $conditions, $chartType);
            $data = array_merge($data,$results);

            $this->set('data', $data);
            
            $rules = $this->getCustomerRules();
            $this->set(compact('systems', 'rules'));
        }
    }
}
