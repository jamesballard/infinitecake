<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 27/10/12
 * Time: 20:50
 */
class StatsController extends AppController {
    public $helpers = array('GChart.GChart', 'DrasticTreeMap.DrasticTreeMap', 'autoComplete.autoCompleteRemote');
    public $components = array('Session');

    // $uses is where you specify which models this controller uses
    var $uses = array('Action', 'FactSummedActionsDatetime', 'FactSummedVerbRuleDatetime');
       
	public function overview() {
    		//Set defaults
	        $period = 'month';
	        $chartType = 'area';
	        $reportType = 'Activity';
	        $system = 0;
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
        	
	        $results = $this->getOverviewData($period, $system);
            $data = array_merge($data,$results);

            $systems = array(0=>'All');
            $systems = array_merge($systems, $this->FactSummedActionsDatetime->System->find('list'));
            $this->set(compact('systems'));

            $this->set('data', $data);

    }

	public function hourly() {
            $report = 'sum';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $report = $this->request->data['Action']['report'];
                $width = $this->request->data['Action']['width'];
                $height = $this->request->data['Action']['height'];
            }

            $this->set('width', $width);
            $this->set('height', $height);

            $dayData = $this->FactSummedActionsDatetime->getHourStats('day', $report, array());
            $dayData = base64_encode(serialize($dayData));

            $this->set('dayData', $dayData);

            $nightData = $this->FactSummedActionsDatetime->getHourStats('night', $report, array());
            $nightData = base64_encode(serialize($nightData));

            $this->set('nightData', $nightData);
    }

    public function stream() {
    
    }
    

    public function location() {
    	//Set defaults
    	$period = 'month';
    	$chartType = 'column';
    	$reportType = 'Activity';
    	$width = 750;
    	$height = 500;
    	
    	//Overwrite defaults if form submitted.
    	if ($this->request->is('post')) {
    		$period = $this->request->data['Action']['period'];
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
    	$results = $this->getIPData($period);
    	$data = array_merge($data,$results);
    	
    	$this->set('data', $data);

    }

    public function help() {
    
    }
    
    public function modules() {
        //Set defaults
            $reportType = 'Activity';
            $system = 0;
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
            $this->set('data', $this->getModuleData($system));

            $systems = array(0=>'All');
            $systems = array_merge($systems, $this->FactSummedActionsDatetime->System->find('list'));
            $this->set(compact('systems'));

    }

    public function tasktype() {
        //Set defaults
            $period = 'month';
            $chartType = 'column';
            $reportType = 'Activity';
            $width = 750;
            $height = 500;

            //Overwrite defaults if form submitted.
            if ($this->request->is('post')) {
                $period = $this->request->data['Action']['period'];
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
            $results = $this->getTaskTypeData($period);
            $data = array_merge($data,$results);

            $this->set('data', $data);
    }

        /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getOverviewData($period, $system) {
        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M";
            break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W';
            break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M";
            break;
        }

        $conditions = array();
        if($system > 0) {
            $conditions = array_merge($conditions,array('FactSummedActionsDatetime.system_id' => $system));
        }
        $data = $this->FactSummedActionsDatetime->getPeriodCountGchart($conditions, $interval, $dateFormat);
        return $data;
    }

    /**
     * Contructs and returns module treemap data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getModuleData($system) {
        $conditions = array();
        if($system > 0) {
            $conditions = array_merge($conditions,array('FactSummedActionsDatetime.system_id' => $system));
        }
        $data = $this->FactSummedActionsDatetime->getModuleCountTreemap($conditions);
        return $data;
    }

   /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */

    private function getTaskTypeData($period) {
        switch($period) {
            case 'day':
                $interval = 'P1D';
                $dateFormat = "d-M-y";
                $data = $this->FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,array(), $interval, $dateFormat);
                return $data;
                break;
            case 'week':
                $interval = 'P1W';
                $dateFormat = 'W-o';
                $data = $this->FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,array(), $interval, $dateFormat);
                return $data;
                break;
            case 'month':
                $interval = 'P1M';
                $dateFormat = "M-y";
                $data = $this->FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,array(), $interval, $dateFormat);
                return $data;
                break;
        }
    }
    
    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    private function getIPData($period) {
    	switch($period) {
    		case 'day':
    			$interval = 'P1D';
    			$dateFormat = "d-M-y";
    			$data = $this->FactSummedVerbRuleDatetime->getIPRuleCountGchart(2,array(), $interval, $dateFormat);
    			return $data;
    			break;
    		case 'week':
    			$interval = 'P1W';
    			$dateFormat = 'W-o';
    			$data = $this->FactSummedVerbRuleDatetime->getIPRuleCountGchart(2,array(), $interval, $dateFormat);
    			return $data;
    			break;
    		case 'month':
    			$interval = 'P1M';
    			$dateFormat = "M-y";
    			$data = $this->FactSummedVerbRuleDatetime->getIPRuleCountGchart(2,array(), $interval, $dateFormat);
    			return $data;
    			break;
    	}
    }
}

