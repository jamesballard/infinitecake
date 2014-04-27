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

class CanvasJSHelper extends AppHelper {

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