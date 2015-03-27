<?php
/**
 * Description
 *
 * @package    CakePHP
 * @subpackage CanvasJS
 * @copyright  &copy; 2013 Infinterooms Ltd  {@link http://www.infiniterooms.co.uk}
 * @author     james.ballard
 * @version    1.0
 */

class zingChartsHelper extends AppHelper {

    public $helpers = array('Html', 'Js');

    const SERIES_STANDARD = 1; // A standard x => y series.
    const SERIES_LABELLED = 2; // A grouped standard series.
    const SERIES_HIERARCHY = 3; // A hierarchically grouped standard series.
    const SERIES_CUSTOM = 4; // A customised series.
    const SERIES_PIE = 5; // A pie chart has own series structure
    const SERIES_DYNAMIC_CHILD = 6; // A chart supporting dynamically generated child on click // A pie chart has own series structure
    const SERIES_TABLE = 7; // A chart supporting dynamically generated child on click

    protected function trimEndComma($string) {
        return rtrim($string, ',');
    }

    /**
     * Creates a div tag meant to be filled with the Google visualization.
     *
     * @param string $name
     * @param array $options
     * @return string Div tag output
     */
    public function start($name, $options=array()) {
        $options = array_merge(array('id' => $name), $options);
        $o = $this->Html->tag('div', '', $options);
        return $o;
    }

    /**
     * Determined the type of series required.
     *
     * $param stdClass $report
     * $return boolean
     */
    protected function getSeriesType($report) {
        if ($report['Report']['visualisation'] == Report::VISUALISATION_TREEMAP) {
            return self::SERIES_HIERARCHY;
        } else if ($report['Report']['visualisation'] == Report::VISUALISATION_TABLE) {
            return self::SERIES_TABLE;
        } else if ($report['Report']['visualisation'] == Report::VISUALISATION_PIE) {
            return self::SERIES_PIE;
        } else if (isset($report['Report']['series'])) {
            if($report['Report']['series']['url']) {
                return self::SERIES_DYNAMIC_CHILD;
            } else {
                return self::SERIES_CUSTOM;
            }
        } else {
            foreach ($report['ReportDimension'] as $reportDimension) {
                switch ($reportDimension['type']) {
                    case 1:
                        break;
                    case 2:
                        if (isset($reportDimension['model']) and !empty($reportDimension['model'])) {
                            return self::SERIES_LABELLED;
                        } else {
                            return self::SERIES_STANDARD;
                        }
                    default:
                        break;
                }
            }
        }
    }

    /**
     * Opens the chart Object.
     *
     * @return string
     */
    protected function openChartObject() {
        return 'var myChart = {';
    }

    /**
     * Set the background colour for graph set.
     *
     * @param string $color
     * @return string
     */
    protected function setBackgroundColour($color='#ecf2f6') {
        return 'backgroundColor: "'.$color.'",';
    }

    /**
     * @return string
     */
    protected function openGraphSet() {
        return '"graphset":[';
    }

    protected function createGraph($report, $data) {
        $chart = Report::$visualisation_display[$report['Report']['visualisation']];
        $seriesType = $this->getSeriesType($report);

        $o = '{';
        $o .= $this->setType($chart);
        $o .= $this->setBackgroundColour('#ffffff');
        $o .= $this->formatGraph($report);
        if(isset($report['Report']['title'])) {
            $o .= $this->setComponent('title', $report);
        }
        if(isset($report['Report']['scale-x'])) {
            $o .= $this->setComponent('scale-x', $report);
        }
        if(isset($report['Report']['scale-y'])) {
            $o .= $this->setComponent('scale-y', $report);
        }
        if(isset($report['Report']['plotarea'])) {
            $o .= $this->setComponent('plotarea', $report);
        }
        if ($seriesType == self::SERIES_LABELLED) {
            $o .= $this->setLegend();
        }
        if ($seriesType == self::SERIES_TABLE) {
            $o .= $this->setTableHeader($data);
        }
        $plotValues = $this->getPlotValues($chart, $report);
        $o .= $this->setPlot($plotValues);

        $o .= $this->setGraphConfiguration($chart);

        $o .= $this->openSeries();
        switch ($seriesType) {
            case self::SERIES_STANDARD:
                $o .= $this->setStandardSeries($data, $report);
                break;
            case self::SERIES_LABELLED:
                $o .= $this->setLabelledSeries($data, $report);
                break;
            case self::SERIES_TABLE:
                $o .= $this->setTableSeries($data, $report);
                break;
            case self::SERIES_HIERARCHY:
                $o .= $this->setHierarchySeries($data, $report);
                break;
            case self::SERIES_CUSTOM:
                $o .= $this->setCustomSeries($data, $report);
                break;
            case self::SERIES_PIE:
                $o .= $this->setPieSeries($data, $report);
                break;
            case self::SERIES_DYNAMIC_CHILD:
                $o .= $this->setDynamicChildSeries($data, $report);
                break;
        }
        $o .= $this->closeSeries();

        $o .= '}';
        return $o;
    }

    protected function setType($chart) {
        return 'type   : "'.$chart.'",';
    }

    protected function formatGraph($report) {
        return '"border-color":"'.(isset($report['Report']['border-color']) ? $report['Report']['border-color'] : '#dae5ec').'",
                "border-width":"'.(isset($report['Report']['border-width']) ? $report['Report']['border-width'] : '1px').'",
                height:"'.(isset($report['Report']['height']) ? $report['Report']['height'] : '100%').'",
                width:"'.(isset($report['Report']['width']) ? $report['Report']['width'] : '100%').'",
                x:"'.(isset($report['Report']['x']) ? $report['Report']['x'] : '0%').'",
                y:"'.(isset($report['Report']['y']) ? $report['Report']['y'] : '0%').'",';
    }

    protected function configArraytoString($array) {
        $o = '';
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $o .= '"'.$k.'" : {';
                foreach ($v as $sk => $sv) {
                    $o .= '"'.$sk.'":"'.$sv.'",';
                }
                $o = $this->trimEndComma($o);
                $o .= "},";
            } else {
                $o .= '"'.$k.'":"'.$v.'",';
            }
        }
        $o = $this->trimEndComma($o);
        return $o;
    }

    protected function setComponent($name, $report) {
        $o = '"'.$name.'"  : {';
        $o .= $this->configArraytoString($report['Report'][$name]);
        $o .= '},';
        return $o;
    }

    protected function setLegend() {
        return 'chart : {
                },
                legend: {},';
    }

    protected function getPlotValues($chart, $report) {
        $plot = array(
            'line-width' => 1,
            'shadow' => 0,
            'exact' => true,
            'tooltip' => array(
                'text' => '%k: %v',
            )
        );
        //TODO: Needs configuration per graph - user interface controlled.
        switch($chart) {
            case 'radar':
                $plot['aspect'] = 'rose';
                break;
            default:
                break;
        }
        if(isset($report['Report']['plot'])) {
            $plot = array_merge($plot, $report['Report']['plot']);
        }
        return $plot;
    }

    protected function setPlot($values) {
        $plot = 'plot:{';
        $plot .= $this->configArraytoString($values);
        $plot = $this->trimEndComma($plot);
        $plot .= '},';
        return $plot;
    }

    /**
     * Sets any graph specific configuration
     *
     * @param $chart
     * @return string
     */
    protected function setGraphConfiguration($chart) {
        //TODO: Needs configuration per graph - user interface controlled.
        switch($chart) {
            case 'radar':
                return '"scale-k":{
                            "aspect":"circle"
                        },';
            default:
                return '';
        }
    }

    protected function openSeries() {
        return 'series : [';
    }

    protected function setStandardSeries($data) {
        $values = '{values:[';
        foreach ($data as $point) {
            foreach ($point as $x => $y) {
                $values .= '["'.$x.'",'.(int)$y.'],';
            }
        }
        $values = $this->trimEndComma($values);
        $values .= '],"target":"graph"}';
        return $values;
    }

    protected function setDynamicChildSeries($data, $report) {
        $values = '{values:[';
        foreach ($data as $point) {
            foreach ($point as $x => $y) {
                $values .= '["'.$x.'",'.(int)$y.'],';
            }
        }
        $values = $this->trimEndComma($values);
        $values .= '],';
        $values .= $this->configArraytoString($report['Report']['series']);
        $values .= '}';
        return $values;
    }

    protected function setLabelledSeries($data) {
        $values = '';
        foreach ($data as $label => $series) {
            $values .= '{text: "'.$label.'", values:[';
            foreach ($series as $x => $y) {
                $values .= '["'.$x.'",'.(int)$y.'],';
            }
            $values = $this->trimEndComma($values);
            $values .= '],"target":"graph"},';
        }
        $values = $this->trimEndComma($values);
        return $values;
    }

    protected function setTableSeries($data) {
        $grid = array();
        foreach ($data as $label => $series) {
            foreach ($series as $x => $y) {
                $grid[$x][] = (int)$y;
            }
        }

        $values = '';
        foreach ($grid as $x => $y) {
            $values .= '{values:["'.$x.'","'.implode('","', $y).'"]},';
        }
        $values = $this->trimEndComma($values);
        return $values;
    }

    protected function getCustomSeriesValues($data, $name, $type) {
        switch ($type) {
            case 'plot':
                $values = '"'.$name.'":[';
                foreach ($data as $point) {
                    foreach ($point as $x => $y) {
                        $values .= '["'.$x.'",'.(int)$y.'],';
                    }
                }
                $values = $this->trimEndComma($values);
                $values .= '],';
                return $values;
            case 'raw':
                $values = '"'.$name.'":[';
                foreach ($data as $point) {
                    foreach ($point as $x => $y) {
                        $values .= '"'.(int)$y.'",';
                    }
                }
                $values = $this->trimEndComma($values);
                $values .= '],';
                return $values;
            case 'max':
                $max = 1;
                foreach ($data as $point) {
                    foreach ($point as $x => $y) {
                        if($y > $max) {
                            $max = $y;
                        }
                    }
                }
                $values = '"'.$name.'":[';
                foreach ($data as $point) {
                    foreach ($point as $x => $y) {
                        $values .= (int)$max.',';
                    }
                }
                $values = $this->trimEndComma($values);
                $values .= '],';
                return $values;
        }
    }

    protected function setSeriesStyles($data, $styles) {
        $o = '"styles":[';
        foreach ($data as $point) {
            foreach ($point as $x => $y) {
                $o .= '{';
                $o .= $this->configArraytoString($styles);
                $o .= '},';
            }
        }
        $o = $this->trimEndComma($o);
        $o .= '],';
        return $o;
    }

    protected function setCustomSeries($data, $report) {
        $o = '';
        foreach($report['Report']['series'] as $series) {
            $o .= '{';
            if (isset($series['values'])) {
                $o .= $this->getCustomSeriesValues($data, 'values', $series['values']);
                unset($series['values']);
            }
            if (isset($series['data-rvalues'])) {
                $o .= $this->getCustomSeriesValues($data, 'data-rvalues', $series['data-rvalues']);
                unset($series['data-rvalues']);
            }
            if (isset($series['styles'])) {
                $o .= $this->setSeriesStyles($data, $series['styles']);
                unset($series['styles']);
            }
            $o .= $this->configArraytoString($series);
            $o = $this->trimEndComma($o);
            $o .= '},';
        }
        $o = $this->trimEndComma($o);
        return $o;
    }

    protected function setPieSeries($data) {
        $values = '';
        foreach ($data as $point) {
            foreach ($point as $x => $y) {
                $values .= '{
                    "values":['.(int)$y.'],
                    "text":"'.$x.'",
                    "target":"graph"
                },';
            }
        }
        $values = $this->trimEndComma($values);
        return $values;
    }

    protected function setHierarchySeries($data) {
        $o = '';
        foreach($data as $key => $value) {
            $o .= '{"text":"'.$key.'",';
            $o .= '"children":[';
            foreach ($value as $x => $y) {
                $o .= '{"text":"'.$x.' ('.$key.')",';
                $o .= '"value":'.$y.',"target":"graph"},';
            }
            $o = $this->trimEndComma($o);
            $o .= ']},';
        }
        $o = $this->trimEndComma($o);
        return $o;
    }

    /**
     * Recursively traverses a multi-dimensional array to return Treemap Series.
     *
     * @param $array
     * @param $report
     * @return string
     */
    protected function traverseHierachySeries(Array $array, $report) {
        $o = '';
        foreach($array as $k => $v) {
            debug($k);
            if(is_array($v)) {
                $o .= '{"text":"'.$k.'",';
                $o .= '"children":[';
                $o .= $this->traverseHierachySeries($v, $report);
                $o = $this->trimEndComma($o);
                $o .=  ']},';
            }else{
                $o .= '{"text":"'.$k.'",';
                $o .= '"value":"'.$v.'","target":"graph"},';
            }
        }
        return $o;
    }

    /**
     * Set headers for table data where labels are headers
     * @param $data
     * @return string
     */
    protected function setTableHeader($data) {
        $o = '"options":{
                "header-row":true,
                "col-labels":["",';
        foreach ($data as $label => $series) {
            $o .= '"'.$label.'",';
        }
        $o = $this->trimEndComma($o);
        $o .= ']},';
        return $o;
    }

    protected function closeSeries() {
        return ']';
    }

    protected function closeGraphSet() {
        return ']';
    }

    protected function closeChartObject() {
        return '};';
    }

    /**
     * Render the chart object.
     *
     * @param string $container
     * @return string
     */
    protected function getChartRender($container, $width='90%', $height='98%') {
        $o = 'window.onload=function(){
                zingchart.render({
                    autoResize: true,
                    id : "'.$container.'",
                    height : "'.$height.'",
                    width : "'.$width.'",
                    data : myChart
                });
            };';
        return $o;
    }

    /**
     * Return a graph for the given data into specified container.
     *
     * @param string $container - element id for chart container.
     * @param array $report - the report details (e..g name)
     * @param array $data - multi-dimensional data array
     * @return string JS script
     */
    public function addZingChart($container, $report, $data, $width='85%', $height='99%') {
        $o = '<script>';
        $o .= $this->openChartObject();
        $o .= $this->setBackgroundColour();
        $o .= $this->openGraphSet();
        $o .= $this->createGraph($report, $data);
        $o .= $this->closeGraphSet();
        $o .= $this->closeChartObject();
        $o .= $this->getChartRender($container, $width, $height);
        $o .= '</script>';
        return $o;
    }

    /**
     * Return multiple graphs for the given data into containers with id chart $i.
     * @param $dashboards
     * @param string $width
     * @param string $height
     * @return string
     */
    public function addDashboardChart($dashboards, $width='100%', $height='100%') {
        $o = '<script>';
        $o .= $this->createRenderVar('svg', $width, $height);
        $o .= $this->openOnLoadFunction();
        $i = 1;
        foreach ($dashboards as $dashboard) {
            $o .= $this->configureGraph($dashboard['config'], $dashboard['data'], $i);
            $i++;
        }
        $o .= '};';
        $o .= '</script>';
        return $o;
    }

    /**
     * Returns the render variable for utilising multiple charts in a single page.
     * @param string $output
     * @param string $width
     * @param string $height
     * @return string
     */
    protected function createRenderVar($output='svg', $width, $height) {
        return 'var toRender={
                id:null,
                output:"'.$output.'",
                height:"'.$height.'",
                width:"'.$width.'",
                defaultsurl:"/app/zingtheme/material.txt",
                data:null
            };';
    }

    /**
     * Returns an open Window.onload function to contain chart.
     * @return string
     */
    protected function openOnLoadFunction() {
        return 'window.onload=function(){';
    }

    protected function configureGraph($report, $data, $i) {
        $chart = Report::$visualisation_display[$report['Report']['visualisation']];
        $seriesType = $this->getSeriesType($report);

        $o = 'toRender.id= "chart'.$i.'";';
        $o .= 'toRender.width= "'.(isset($report['Report']['width']) ? $report['Report']['width'] : '100%').'";';
        $o .= 'toRender.height= "'.(isset($report['Report']['height']) ? $report['Report']['height'] : '100%').'";';

        $o .= 'toRender.data= {';

        $o .= $this->setType($chart);
        if(isset($report['Report']['stacked'])) {
            $o .= '"stacked":true,';
        }
        $o .= $this->setBackgroundColour('#ffffff');
        $o .= $this->formatGraph($report);
        /*if(isset($report['Report']['title'])) {
            $o .= $this->setComponent('title', $report);
        }*/
        if(isset($report['Report']['scale-x'])) {
            $o .= $this->setComponent('scale-x', $report);
        }
        if(isset($report['Report']['scroll-x'])) {
            $o .= $this->setComponent('scroll-x', $report);
        }
        if(isset($report['Report']['preview'])) {
            $o .= $this->setComponent('preview', $report);
        }
        if(isset($report['Report']['scale-y'])) {
            $o .= $this->setComponent('scale-y', $report);
        }
        if(isset($report['Report']['plotarea'])) {
            $o .= $this->setComponent('plotarea', $report);
        }
        if ($seriesType == self::SERIES_LABELLED) {
            if(isset($report['Report']['legend']) and $report['Report']['legend'] === false) {
                $o .= '';
            } else {
                $o .= $this->setLegend();
            }
        }

        if ($seriesType == self::SERIES_TABLE) {
            $o .= $this->setTableHeader($data);
        }

        $plotValues = $this->getPlotValues($chart, $report);
        $o .= $this->setPlot($plotValues);

        $o .= $this->setGraphConfiguration($chart);

        $o .= $this->openSeries();
        switch ($seriesType) {
            case self::SERIES_STANDARD:
                $o .= $this->setStandardSeries($data, $report);
                break;
            case self::SERIES_LABELLED:
                $o .= $this->setLabelledSeries($data, $report);
                break;
            case self::SERIES_TABLE:
                $o .= $this->setTableSeries($data, $report);
                break;
            case self::SERIES_HIERARCHY:
                $o .= $this->setHierarchySeries($data, $report);
                break;
            case self::SERIES_CUSTOM:
                $o .= $this->setCustomSeries($data, $report);
                break;
            case self::SERIES_PIE:
                $o .= $this->setPieSeries($data, $report);
                break;
            case self::SERIES_DYNAMIC_CHILD:
                $o .= $this->setDynamicChildSeries($data, $report);
                break;
        }
        $o .= $this->closeSeries();

        $o .= '};';
        $o .= 'zingchart.render(toRender);';
        return $o;
    }

    /**
     * Creates chart with JSON feed for data.
     * TODO: check cache - does this work effectively for changing data.
     * @param $name
     * @param $url
     * @param $width
     * @param $height
     * @return string
     */
    public function json_feed($name, $url, $width='100%', $height='600') {
        $o = '<script>';
        $o .= 'zingchart.render({
            id:"'.$name.'",
            output:"svg",
            height:"'.$height.'",
            width:"'.$width.'",
            dataurl:"'.$url.'",
            defaultsurl:"/app/zingtheme/material.txt"
        });';
        $o .= '</script>';
        return $o;
    }

    /**
     * Returns the render variable for utilising multiple charts in a single page.
     * @param string $output
     * @return string
     */
    protected function jsonRenderVar($output='svg') {
        return 'var toRender={
                id:null,
                output:"'.$output.'",
                height:"400",
                width:"100%",
                defaultsurl:"/app/zingtheme/material.txt",
                dataurl:null
            };';
    }

    public function configureJsonGraph($charts) {
        $o = '<script>';
        $o .= $this->jsonRenderVar();
        $o .= 'window.onload=function(){';
        foreach($charts as $chart) {
            $o .= 'toRender.id= "'.$chart->id.'";';
            $o .= 'toRender.width= "'.$chart->width.'";';
            $o .= 'toRender.height= "'.$chart->height.'";';
            $o .= 'toRender.dataurl= "'.$chart->url.'";';
            $o .= 'zingchart.render(toRender);';
        }
        $o .= '}';
        $o .= '</script>';
        return $o;
    }
}