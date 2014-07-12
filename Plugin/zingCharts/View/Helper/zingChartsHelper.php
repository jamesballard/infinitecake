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
        } else if ($report['Report']['visualisation'] == Report::VISUALISATION_PIE) {
            return self::SERIES_PIE;
        } else if (isset($report['Report']['series'])) {
            return self::SERIES_CUSTOM;
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
            case self::SERIES_HIERARCHY:
                $o .= $this->setHierarchySeries($data, $report);
                break;
            case self::SERIES_CUSTOM:
                $o .= $this->setCustomSeries($data, $report);
                break;
            case self::SERIES_PIE:
                $o .= $this->setPieSeries($data, $report);
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
                height:"'.(isset($report['Report']['height']) ? $report['Report']['height'] : '98%').'",
                width:"'.(isset($report['Report']['width']) ? $report['Report']['width'] : '98%').'",
                x:"'.(isset($report['Report']['x']) ? $report['Report']['x'] : '1%').'",
                y:"'.(isset($report['Report']['y']) ? $report['Report']['y'] : '1%').'",';
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
        $values .= ']}';
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
            $values .= ']},';
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
            $o .= $this->getCustomSeriesValues($data, 'values', $series['values']);
            if (isset($series['data-rvalues'])) {
                $o .= $this->getCustomSeriesValues($data, 'data-rvalues', $series['data-rvalues']);
                unset($series['data-rvalues']);
            }
            unset($series['values']);
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
                    "text":"'.$x.'"
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
                $o .= '"value":'.$y.'},';
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
     * @return string
     */
    protected function traverseHierachySeries($array) {
        //TODO: Needs fixing for multi-tiered hierarchy.
        $o = '';
        foreach($array as $key => $value) {
            $o .= '{"text":"'.$key.'",';
            if (is_array($value)) {
                $o .= '"children":[';
                $this->traverseHierachySeries($value);
                $o = $this->trimEndComma($o);
                $o .= ']},';
            } else {
                $o .= '"value":'.$value.'},';
            }
        }
        $o = $this->trimEndComma($o);
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
     * Return multiple graphs for the given data into specified container.
     *
     * @param string $container - element id for chart container.
     * @param array $dashboards - the dashboard details incl data array.
     * @return string JS script
     */
    public function addDashboardChart($container, $dashboards, $width='85%', $height='99%') {
        $o = '<script>';
        $o .= $this->openChartObject();
        $o .= $this->setBackgroundColour();
        $o .= $this->openGraphSet();
        foreach ($dashboards as $dashboard) {
            $o .= $this->createGraph($dashboard['config'], $dashboard['data']);
            $o .= ',';
        }
        $o = $this->trimEndComma($o);
        $o .= $this->closeGraphSet();
        $o .= $this->closeChartObject();
        $o .= $this->getChartRender($container, $width, $height);
        $o .= '</script>';
        return $o;
    }
}

/*
{
"graphset":[
    {
        "type":"treemap",
        "plotarea":{
            "margin":"0 0 30 0"
        },
        "tooltip":{

        },
        "options":{

        },
        "series":[
            {
                "text": "2011/12",
                "children":[
                    {
                       "text": "Forum",
                        "value": 703823
                    }
                ]
            },
            {
                "text": "2012/13",
                "children": [
                    {
                        "text": "Forum",
                        "value": 703823
                    }
                ]
            },
            {
                "text": "2013/14",
                "children": [
                    {
                        "text": "Forum",
                        "value": 703823
                    }
                ]
            }
        ]
        "series":[
            {
                "text":"North America",
                "children":[
                    {
                        "text":"United States",
                        "children":[
                            {
                                "text":"Texas",
                                "value":21
                            },
                            {
                                "text":"California",
                                "value":53
                            },
                            {
                                "text":"Ohio",
                                "value":12
                            },
                            {
                                "text":"New York",
                                "value":46
                            },
                            {
                                "text":"Michigan",
                                "value":39
                            },
                            {
                                "text":"Alabama",
                                "value":25
                            }
                        ]
                    },
                    {
                        "text":"Canada",
                        "value":113
                    },
                    {
                        "text":"Mexico",
                        "value":78
                    }
                ]
            },
            {
                "text":"Europe",
                "children":[
                    {
                        "text":"France",
                        "value":42
                    },
                    {
                        "text":"Spain",
                        "value":28
                    },
                    {
                        "text":"Switzerland",
                        "value":13
                    },
                    {
                        "text":"Germany",
                        "value":56
                    },
                    {
                        "text":"Cyprus",
                        "value":7
                    }
                ]
            },
            {
                "text":"Africa",
                "children":[
                    {
                        "text":"Egypt",
                        "value":22
                    },
                    {
                        "text":"Congo",
                        "value":38
                    },
                    {
                        "text":"Lesotho",
                        "value":9
                    }
                ]
            },
            {
                "text":"Asia",
                "children":[
                    {
                        "text":"India",
                        "value":92
                    },
                    {
                        "text":"China",
                        "value":68
                    },
                    {
                        "text":"Mongolia",
                        "value":25
                    }
                ]
            },
            {
                "text":"South America",
                "children":[
                    {
                        "text":"Brazil",
                        "value":42
                    },
                    {
                        "text":"Argentina",
                        "value":28
                    },
                    {
                        "text":"Peru",
                        "value":15
                    },
                    {
                        "text":"Uruguay",
                        "value":33
                    }
                ]
            },
            {
                "text":"Australia (continent)",
                "children":[
                    {
                        "text":"Australia (country)",
                        "value":121
                    },
                    {
                        "text":"New Zealand",
                        "value":24
                    }
                ]
            }
        ]
    }
]
}
*/