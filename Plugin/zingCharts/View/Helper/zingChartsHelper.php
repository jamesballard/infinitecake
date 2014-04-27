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
     * Check if report uses labels.
     *
     * $param stdClass $report
     * $return boolean
     */
    protected function useLabels($report) {
        foreach ($report['ReportDimension'] as $reportDimension) {
            switch ($reportDimension['type']) {
                case 1:
                    break;
                case 2:
                    if (isset($reportDimension['parameter']) and !empty($reportDimension['parameter'])) {
                        return true;
                    } else {
                        return false;
                    }
                default:
                    break;
            }
        }
    }

    /**
     * Configure the chart object.
     *
     * @param array $report
     * @param array $data
     * @return string
     */
    protected function getChartObject($report, $data) {
        $useLabels = $this->useLabels($report);

        $chart = Report::$visualisation_display[$report['Report']['visualisation']];
        $o = 'var myChart = {
            type   : "'.$chart.'",
            backgroundColor: "#ffffff",
            title  : {
                text: "'.$report['Report']['name'].'",
                backgroundColor:"#ffffff",
                fontFamily:"Helvetica",
                fontColor:"#333333",
                textAlign: "left",
                fontSize: 32
            },';

        if ($useLabels) {
            $o .= 'legend  : {},';
        }

        $o .=  'plot:{
                "line-width":1,
                "shadow":0,
                "exact":true
            },
            series : [';
        if ($useLabels) {
            foreach ($data as $label => $series) {
                $o .= '{text: "'.$label.'", values:[';
                foreach ($series as $points) {
                    foreach ($points as $x => $y) {
                        $o .= '["'.$x.'",'.(int)$y.'],';
                    }
                }
                $o = rtrim($o, ',');
                $o .= ']},';
            }
        } else {
            $o .= '{values:[';
            foreach ($data as $point) {
                foreach ($point as $x => $y) {
                    $o .= '["'.$x.'",'.(int)$y.'],';
                }
            }
            $o = rtrim($o, ',');
            $o .= ']},';
        }
        $o = rtrim($o, ',');
        $o .= ']';
        $o .= '};';
        return $o;
    }

    /**
     * Render the chart object.
     *
     * @param string $container
     * @return string
     */
    protected function getChartRender($container) {
        $o = 'window.onload=function(){
                zingchart.render({
                    autoResize: true,
                    id : "'.$container.'",
                    height : "100%",
                    width : "auto",
                    data : myChart,
                });
            };';
        return $o;
    }

    /**
     * Return a line graph for the given data into specified container.
     *
     * @param string $container - element id for chart container.
     * @param array $report - the report details (e..g name)
     * @param array $data - multi-dimensional data array
     * @return string JS script
     */
    public function addZingChart($container, $report, $data) {
        $o = '<script>';
        $o .= $this->getChartObject($report, $data);
        $o .= $this->getChartRender($container);
        $o .= '</script>';
        return $o;
    }



    /**
     * Return a line graph for the given data into specified container.
     *
     * @param string $container - element id for chart container.
     * @param array $report - the report details (e..g name)
     * @param array $data - multi-dimensional data array
     * @return string JS script
     */
    public function drawLabelGraph($container, $report, $data) {
        $chart = Report::$visualisation_display[$report['Report']['visualisation']];
        $o = '<script type="text/javascript">
                window.onload = function () {
                    var chart = new CanvasJS.Chart("'.$container.'",
                {
                    title:{
                        text: "'.$report['Report']['name'].'",
                        fontFamily: "MyriadPro-Regular",
                        fontColor: "#5451a2",
                        horizontalAlign: "left"
                    },
                    axisY: {
                        fontFamily: "Helvetica",
                        interlacedColor: "#eaeaea"
                    },
                    axisX: {
                        fontFamily: "Helvetica",
                        gridColor: "#d3d3d3"
                    },
                    theme: "theme2",
                    data: [';
        foreach ($data as $label => $series) {
            $o .= '{
                        type: "'.$chart.'",
                        lineThickness:3,
                        axisYType:"secondary",
                        showInLegend: true,
                        name: "'.$label.'",
                        dataPoints: [';
            foreach ($series as $points) {
                foreach ($points as $x => $y) {
                    $o .= '{ label: "'.$x.'", y: '.(int)$y.' },';
                }
            }
            trim($o, ",");
            $o .= '     ]
                     },';
        }
        trim($o, ",");
        $o .= '],
                  legend: {
                        fontFamily: "Helvetica",
                        cursor:"pointer",
                    itemclick : function(e) {
                            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            }
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart.render();
                        }
                  }
                });

        chart.render();
        }
        </script>';
        return $o;
    }

}