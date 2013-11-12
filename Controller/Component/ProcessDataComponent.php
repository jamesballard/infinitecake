<?php
App::uses('Component', 'Controller');
App::uses('Action', 'Model');
App::uses('FactSummedVerbRuleDatetime', 'Model');

class ProcessDataComponent extends Component {
   
    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getOverviewData($dateWindow, $period, $conditions) {
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
    	$Action = new Action();
    	$data = $Action->getPeriodCountGchart($dateWindow, $conditions, $interval, $dateFormat);
    	return $data;
    }
    
    /**
     * Contructs and returns module treemap data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getModuleData($dateWindow, $conditions) {
    	$FactSummedActionsDatetime = new FactSummedActionsDatetime();
    	$data = $FactSummedActionsDatetime->getModuleCountTreemap($dateWindow, $conditions);
    	return $data;
    }
    
    /**
     * Contructs and returns hourly total data.
     *
     * @param string $period 'day' or 'night'
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getHourlyData($dateWindow, $period,$report,$conditions) {
    	$FactSummedActionsDatetime = new FactSummedActionsDatetime();
    	$data = $FactSummedActionsDatetime->getHourStats($dateWindow, $period, $report, $conditions);
    	
    	return base64_encode(serialize($data));
    
    }
    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period Determines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @param string type of chart to be displayed
     * @return array Data for chart
     */
    
    public function getTaskTypeData($dateWindow, $period, $rule, $conditions, $chart) {
    	$FactSummedVerbRuleDatetime = new FactSummedVerbRuleDatetime();
    	switch($period) {
    		case 'day':
    			$interval = 'P1D';
    			$dateFormat = "d-M-y";
    			break;
    		case 'week':
    			$interval = 'P1W';
    			$dateFormat = 'W-o';
    			break;
    		case 'month':
    			$interval = 'P1M';
    			$dateFormat = "M-y";
    			break;
    	}
    	if($chart == 'pie'):
	    	$data = $FactSummedVerbRuleDatetime->getRulePieChart($dateWindow, $rule,$conditions, $interval, $dateFormat);
	    	return $data;
    	else:
	    	$data = $FactSummedVerbRuleDatetime->getVerbRuleCountGchart($dateWindow, $rule,$conditions, $interval, $dateFormat);
	    	return $data;
	    endif;
    }
    
    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getIPData($dateWindow, $period, $conditions, $chart) {
    	$FactSummedVerbRuleDatetime = new FactSummedVerbRuleDatetime();
    	switch($period) {
    		case 'day':
    			$interval = 'P1D';
    			$dateFormat = "d-M-y";
    			break;
    		case 'week':
    			$interval = 'P1W';
    			$dateFormat = 'W-o';
    			break;
    		case 'month':
    			$interval = 'P1M';
    			$dateFormat = "M-y";
    			break;
    	}

    	if($chart == 'pie'):
	    	$data = $FactSummedVerbRuleDatetime->getIPRulePiechart($dateWindow, 2, $conditions, $interval, $dateFormat);
	    	return $data;
    	else:
	    	$data = $FactSummedVerbRuleDatetime->getIPRuleCountGchart($dateWindow, 2, $conditions, $interval, $dateFormat);
	    	return $data;
    	endif;
    }
}
?>