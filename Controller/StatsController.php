<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 27/10/12
 * Time: 20:50
 */
class StatsController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'autoComplete.autoCompleteRemote');
    public $components = array('Session', 'ProcessData', 'DataFilters');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action');
      
	public function overview() {
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
	        $conditions = $this->DataFilters->returnSystemFilter($system);
        	
	        $results = $this->ProcessData->getOverviewData($dateWindow, $period, $conditions);
            $data = array_merge($data,$results);

            $this->set(compact('systems'));

            $this->set('data', $data);

    }

	public function hourly() {
		$systems = AppController::get_customerSystems();
            $report = 'sum';
            $dateWindow = '-2 years';
            $system = array_keys($systems);
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                //$report = $this->request->data['Action']['report'];
                $dateWindow = $this->request->data['Action']['daterange'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
	        $conditions = $this->DataFilters->returnSystemFilter($system);
	        
            $dayData = $this->ProcessData->getHourlyData($dateWindow, 'day', $report, $conditions);

            $this->set('dayData', $dayData);

            $nightData = $this->ProcessData->getHourlyData($dateWindow, 'night', $report, $conditions);
	        
            $this->set('nightData', $nightData);
            
            $this->set(compact('systems'));
    }

    public function stream() {
    	$systems = AppController::get_customerSystems();
    	
    	//Set defaults.
    	$system = array_keys($systems);
        $dateWindow = '07-05-2013';
    		
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
    			'conditions' => array('Action.system_id' => $system, 
    						'time >'=>date("Y-m-d", strtotime($dateWindow))),
    			'order' => array('time' => 'DESC')
    		)
    	); 
		$this->set('actions', $actions);
		$this->set(compact('systems'));
    }
    

    public function location() {
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
    	$conditions = $this->DataFilters->returnSystemFilter($system);
    	
    	$results = $this->ProcessData->getIPData($dateWindow, $period, $conditions, $chartType);
    	$data = array_merge($data,$results);
    	
    	$this->set('data', $data);
    	$this->set(compact('systems'));

    }

    public function help() {
    
    }
    
    public function modules() {
    	$systems = AppController::get_customerSystems();
        //Set defaults
            $reportType = 'Activity';
            $dateWindow = '-2 years';
            $system = array_keys($systems);
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $system = $this->request->data['Action']['system'];
                $dateWindow = $this->request->data['Action']['daterange'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
            $conditions = $this->DataFilters->returnSystemFilter($system);
            
            $this->set('data', $this->ProcessData->getModuleData($dateWindow, $conditions));

            $this->set(compact('systems'));

    }

    public function tasktype() {
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
                $period = $this->request->data['Action']['period'];
                $dateWindow = $this->request->data['Action']['daterange'];
                $system = $this->request->data['Action']['system'];
                $rule = $this->request->data['Action']['rule'];
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
            $conditions = $this->DataFilters->returnSystemFilter($system);
            
            $results = $this->ProcessData->getTaskTypeData($dateWindow, $period, $rule, $conditions, $chartType);
            $data = array_merge($data,$results);

            $this->set('data', $data);
            
            $rules = $this->getCustomerRules();
            $this->set(compact('systems', 'rules'));
    }
}

