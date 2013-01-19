<?php
App::uses('Component', 'Controller');
App::uses('FactSummedActionsDatetime', 'Model');
App::uses('FactSummedVerbRuleDatetime', 'Model');

class ProcessDataComponent extends Component {
   
    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getOverviewData($period, $conditions) {
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
    	$FactSummedActionsDatetime = new FactSummedActionsDatetime();
    	$data = $FactSummedActionsDatetime->getPeriodCountGchart($conditions, $interval, $dateFormat);
    	return $data;
    }
    
    /**
     * Contructs and returns module treemap data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getModuleData($conditions) {
    	$FactSummedActionsDatetime = new FactSummedActionsDatetime();
    	$data = $FactSummedActionsDatetime->getModuleCountTreemap($conditions);
    	return $data;
    }
    
    /**
     * Contructs and returns hourly total data.
     *
     * @param string $period 'day' or 'night'
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getHourlyData($period,$report,$conditions) {
    	$FactSummedActionsDatetime = new FactSummedActionsDatetime();
    	$data = $FactSummedActionsDatetime->getHourStats($period, $report, $conditions);
    	
    	return base64_encode(serialize($data));
    
    }
    /**
     * Contructs and returns Overview data.
     *
     * @param integer $period De termines how data will be grouped
     * @param integer $reportType Determines fields to be counted
     * @return array Data for chart
     */
    
    public function getTaskTypeData($period, $conditions) {
    	$FactSummedVerbRuleDatetime = new FactSummedVerbRuleDatetime();
    	switch($period) {
    		case 'day':
    			$interval = 'P1D';
    			$dateFormat = "d-M-y";
    			$data = $FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,$conditions, $interval, $dateFormat);
    			return $data;
    			break;
    		case 'week':
    			$interval = 'P1W';
    			$dateFormat = 'W-o';
    			$data = $FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,$conditions, $interval, $dateFormat);
    			return $data;
    			break;
    		case 'month':
    			$interval = 'P1M';
    			$dateFormat = "M-y";
    			$data = $FactSummedVerbRuleDatetime->getVerbRuleCountGchart(1,$conditions, $interval, $dateFormat);
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
    
    public function getIPData($period, $conditions) {
    	$FactSummedVerbRuleDatetime = new FactSummedVerbRuleDatetime();
    	switch($period) {
    		case 'day':
    			$interval = 'P1D';
    			$dateFormat = "d-M-y";
    			$data = $FactSummedVerbRuleDatetime->getIPRuleCountGchart(2, $conditions, $interval, $dateFormat);
    			return $data;
    			break;
    		case 'week':
    			$interval = 'P1W';
    			$dateFormat = 'W-o';
    			$data = $FactSummedVerbRuleDatetime->getIPRuleCountGchart(2, $conditions, $interval, $dateFormat);
    			return $data;
    			break;
    		case 'month':
    			$interval = 'P1M';
    			$dateFormat = "M-y";
    			$data = $FactSummedVerbRuleDatetime->getIPRuleCountGchart(2, $conditions, $interval, $dateFormat);
    			return $data;
    			break;
    	}
    }
}
?>