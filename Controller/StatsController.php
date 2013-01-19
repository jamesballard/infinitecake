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

	        $data = array(
	            'title' => $reportType,
	            'type' => $chartType,
	            'width' => $width,
	            'height' => $height
	        );
	        
	        //Set query filters
	        $conditions = $this->DataFilters->returnSystemFilter($system);
        	
	        $results = $this->ProcessData->getOverviewData($period, $conditions);
            $data = array_merge($data,$results);

            $this->set(compact('systems'));

            $this->set('data', $data);

    }

	public function hourly() {
		$systems = AppController::get_customerSystems();
            $report = 'sum';
            $system = array_keys($systems);
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $report = $this->request->data['Action']['report'];
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
	        $conditions = $this->DataFilters->returnSystemFilter($system);
	        
            $dayData = $this->ProcessData->getHourlyData('day', $report, $conditions);

            $this->set('dayData', $dayData);

            $nightData = $this->ProcessData->getHourlyData('night', $report, $conditions);
	        
            $this->set('nightData', $nightData);
            
            $this->set(compact('systems'));
    }

    public function stream() {
    	$systems = AppController::get_customerSystems();
    	$system = array_keys($systems);
    		//Set defaults
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
    						'DimensionVerb.name'
    					)
    				)
    			),
    			'conditions' => array('Action.system_id' => $system),
    			'order' => array('time' => 'DESC'),
    			'limit' => 500
    		)
    	); 
		$this->set('actions', $actions);
		$this->set(compact('systems'));
    }
    

    public function location() {
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
    	$conditions = $this->DataFilters->returnSystemFilter($system);
    	
    	$results = $this->ProcessData->getIPData($period, $conditions);
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
            $system = array_keys($systems);
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $system = $this->request->data['Action']['system'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);
            
            //Set query filters
            $conditions = $this->DataFilters->returnSystemFilter($system);
            
            $this->set('data', $this->ProcessData->getModuleData($conditions));

            $this->set(compact('systems'));

    }

    public function tasktype() {
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
            $conditions = $this->DataFilters->returnSystemFilter($system);
            
            $results = $this->ProcessData->getTaskTypeData($period, $conditions);
            $data = array_merge($data,$results);

            $this->set('data', $data);
            $this->set(compact('systems'));
    }
}

