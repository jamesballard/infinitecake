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
                x:"'.(isset($report['Report']['x']) ? $report['Report']['x'] : '10px').'",
                y:"'.(isset($report['Report']['y']) ? $report['Report']['y'] : '10px').'",';
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
            foreach ($series as $points) {
                foreach ($points as $x => $y) {
                    $values .= '["'.$x.'",'.(int)$y.'],';
                }
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
"background-color":"#ecf2f6",
"graphset":[
    {
        "type":"bar",
        "background-color":"#fff",
        "border-color":"#dae5ec",
        "border-width":"1px",
        "height":"29%",
        "width":"96%",
        "x":"2%",
        "y":"2%",
        "title":{
            "margin-top":"7px",
            "margin-left":"9px",
            "font-family":"Arial",
            "text":"DEPARTMENT PERFORMANCE",
            "background-color":"none",
            "shadow":0,
            "text-align":"left",
            "font-size":"11px",
            "font-weight":"bold",
            "font-color":"#707d94"
        },
        "scale-y":{
            "values":"0:300:100",
            "line-color":"none",
            "tick":{
                "visible":false
            },
            "item":{
                "font-color":"#8391a5",
                "font-family":"Arial",
                "font-size":"10px",
                "padding-right":"5px"
            },
            "guide":{
                "line-style":"solid",
                "line-width":"1px",
                "line-color":"#d2dae2",
                "alpha":0.4
            }
        },
        "scale-x":{
            "items-overlap":true,
            "max-items":9999,
            "values":["Apparel","Drug","Footwear","Gift Card","Home","Jewelry","Garden","Other"],
            "offset-y":"3px",
            "line-color":"#d2dae2",
            "item":{
                "font-color":"#8391a5",
                "font-family":"Arial",
                "font-size":"11px",
                "padding-top":"2px"
            },
            "tick":{
                "visible":false,
                "line-color":"#d2dae2"
            },
            "guide":{
                "visible":false
            }
        },
        "plotarea":{
            "margin":"45px 20px 38px 45px"
        },
        "plot":{
            "bar-width":"33px",
            "exact":true,
            "hover-state":{
                "visible":false
            },
            "tooltip":{
                "font-color":"#ffffff",
                "font-family":"Arial",
                "font-size":"11px",
                "border-radius":"6px",
                "shadow":false,
                "padding":"5px 10px"
            }
        },
        "series":[
            {
                "values":[150,165,173,201,185,195,162,125],
                "-animation":{
                    "method":4,
                    "effect":4,
                    "speed":2500,
                    "sequence":0
                },
                "styles":[
                    {
                        "background-color":"#4dbac0"
                    },
                    {
                        "background-color":"#25a6f7"
                    },
                    {
                        "background-color":"#ad6bae"
                    },
                    {
                        "background-color":"#707d94"
                    },
                    {
                        "background-color":"#f3950d"
                    },
                    {
                        "background-color":"#e62163"
                    },
                    {
                        "background-color":"#4e74c0"
                    },
                    {
                        "background-color":"#9dc012"
                    }
                ]
            }
        ]
    },
    {
        "type":"hbar",
        "background-color":"#fff",
        "border-color":"#dae5ec",
        "border-width":"1px",
        "x":"2%",
        "y":"33%",
        "height":"65%",
        "width":"30%",
        "title":{
            "margin-top":"7px",
            "margin-left":"9px",
            "text":"BRAND PERFORMANCE",
            "background-color":"none",
            "shadow":0,
            "text-align":"left",
            "font-family":"Arial",
            "font-size":"11px",
            "font-color":"#707d94"
        },
        "scale-y":{
            "line-color":"none",
            "tick":{
                "visible":false
            },
            "item":{
                "visible":false
            },
            "guide":{
                "visible":false
            }
        },
        "scale-x":{
            "values":["Kenmore","Craftsman","DieHard","Land's End","Laclyn Smith","Joe Boxer"],
            "line-color":"none",
            "tick":{
                "visible":false
            },
            "item":{
                "width":200,
                "text-align":"left",
                "offset-x":206,
                "offset-y":-12,
                "font-color":"#8391a5",
                "font-family":"Arial",
                "font-size":"11px",
                "padding-bottom":"8px"
            },
            "guide":{
                "visible":false
            }
        },
        "plot":{
            "bars-overlap":"100%",
            "bar-width":"12px",
            "thousands-separator":",",
            "tooltip":{
                "font-color":"#ffffff",
                "background-color":"#707e94",
                "font-family":"Arial",
                "font-size":"11px",
                "border-radius":"6px",
                "shadow":false,
                "padding":"5px 10px"
            },
            "hover-state":{
                "background-color":"#707e94"
            }
        },
        "plotarea":{
            "margin":"50px 15px 10px 15px"
        },
        "series":[
            {
                "values":[103902,112352,121823,154092,182023,263523],
                "-animation":{
                    "method":0,
                    "effect":4,
                    "speed":2000,
                    "sequence":0
                },
                "z-index":2,
                "styles":[
                    {
                        "background-color":"#4dbac0"
                    },
                    {
                        "background-color":"#4dbac0"
                    },
                    {
                        "background-color":"#4dbac0"
                    },
                    {
                        "background-color":"#4dbac0"
                    },
                    {
                        "background-color":"#4dbac0"
                    },
                    {
                        "background-color":"#4dbac0"
                    }
                ],
                "tooltip-text":"$%node-value"
            },
            {
                "max-trackers":0,
                "values":[300000,300000,300000,300000,300000,300000],
                "data-rvalues":[103902,112352,121823,154092,182023,263523],
                "background-color":"#d9e4eb",
                "z-index":1,
                "value-box":{
                    "visible":true,
                    "offset-y":"-12px",
                    "offset-x":"-54px",
                    "text-align":"right",
                    "font-color":"#8391a5",
                    "font-family":"Arial",
                    "font-size":"11px",
                    "text":"$%data-rvalues",
                    "padding-bottom":"8px"
                }
            }
        ]
    },
    {
        "type":"line",
        "background-color":"#fff",
        "border-color":"#dae5ec",
        "border-width":"1px",
        "width":"64%",
        "height":"65%",
        "x":"34%",
        "y":"33.2%",
        "title":{
            "margin-top":"7px",
            "margin-left":"12px",
            "text":"TODAY'S SALES",
            "background-color":"none",
            "shadow":0,
            "text-align":"left",
            "font-family":"Arial",
            "font-size":"11px",
            "font-color":"#707d94"
        },
        "plotarea":{
            "margin":"50px 25px 70px 46px"
        },
        "scale-y":{
            "values":"0:100:25",
            "line-color":"none",
            "guide":{
                "line-style":"solid",
                "line-color":"#d2dae2",
                "line-width":"1px",
                "alpha":0.5
            },
            "tick":{
                "visible":false
            },
            "item":{
                "font-color":"#8391a5",
                "font-family":"Arial",
                "font-size":"10px",
                "padding-right":"5px"
            }
        },
        "scale-x":{
            "line-color":"#d2dae2",
            "line-width":"2px",
            "values":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            "tick":{
                "line-color":"#d2dae2",
                "line-width":"1px"
            },
            "guide":{
                "visible":false
            },
            "item":{
                "font-color":"#8391a5",
                "font-family":"Arial",
                "font-size":"10px",
                "padding-top":"5px"
            }
        },
        "legend":{
            "layout":"2x2",
            "background-color":"none",
            "shadow":0,
            "margin":"auto auto 15 auto",
            "border-width":0,
            "item":{
                "font-color":"#707d94",
                "font-family":"Arial",
                "padding":"0px",
                "margin":"0px",
                "font-size":"9px"
            },
            "marker":{
                "show-line":"true",
                "type":"match",
                "font-family":"Arial",
                "font-size":"10px",
                "size":4,
                "line-width":2,
                "padding":"3px"
            }
        },
        "crosshair-x":{
            "lineWidth":1,
            "line-color":"#707d94",
            "plotLabel":{
                "shadow":false,
                "font-color":"#ffffff",
                "font-family":"Arial",
                "font-size":"10px",
                "padding":"5px 10px",
                "border-radius":"5px",
                "alpha":1
            },
            "scale-label":{
                "font-color":"#ffffff",
                "background-color":"#707d94",
                "font-family":"Arial",
                "font-size":"10px",
                "padding":"5px 10px",
                "border-radius":"5px"
            }
        },
        "tooltip":{
            "visible":false
        },
        "series":[
            {
                "values":[69,68,54,48,70,74,98,70,72,68,49,69],
                "text":"Kenmore",
                "line-color":"#4dbac0",
                "line-width":"2px",
                "shadow":0,
                "marker":{
                    "background-color":"#fff",
                    "size":3,
                    "border-width":1,
                    "border-color":"#36a2a8",
                    "shadow":0
                },
                "palette":0
            },
            {
                "values":[51,53,47,60,48,52,75,52,55,47,60,48],
                "text":"Craftsman",
                "line-width":"2px",
                "line-color":"#25a6f7",
                "shadow":0,
                "marker":{
                    "background-color":"#fff",
                    "size":3,
                    "border-width":1,
                    "border-color":"#1993e0",
                    "shadow":0
                },
                "palette":1,
                "visible":1
            },
            {
                "values":[42,43,30,50,31,48,55,46,48,32,50,38],
                "text":"DieHard",
                "line-color":"#ad6bae",
                "line-width":"2px",
                "shadow":0,
                "marker":{
                    "background-color":"#fff",
                    "size":3,
                    "border-width":1,
                    "border-color":"#975098",
                    "shadow":0
                },
                "palette":2,
                "visible":1
            },
            {
                "values":[25,15,26,21,24,26,33,25,15,25,22,24],
                "text":"Land's End",
                "line-color":"#f3950d",
                "line-width":"2px",
                "shadow":0,
                "marker":{
                    "background-color":"#fff",
                    "size":3,
                    "border-width":1,
                    "border-color":"#d37e04",
                    "shadow":0
                },
                "palette":3
            }
        ]
    }
]
}
*/