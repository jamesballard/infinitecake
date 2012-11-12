<?php
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class DrasticTreeMapHelper extends AppHelper {

    public $helpers = array('Html');

    /**
     * Creates a div tag meant to be filled with the Google visualization.
     *
     * @param string $name
     * @return string Script tag output
     */
    public function init() {
        $this->Html->script('https://www.google.com/jsapi', false);
        $this->Html->script('DrasticTreemapGApi', false);
        $this->Html->script('swfobject', false);
    }

    /**
     * Creates a div tag meant to be filled with the Treemap visualization.
     *
     * @param string $name
     * @param array $options
     * @return string Div tag output
     */
    public function visualize($name='treemap', $data) {
        $o = '<script type="text/javascript">
            google.load("visualization", "1");
            google.load("swfobject", "2.2");

            // Set callback to run when API is loaded
            google.setOnLoadCallback(drawVisualization);

            // Called when the Visualization API is loaded.
            function drawVisualization() {

                // Create and populate a data table.\n
                var data = new google.visualization.DataTable();';

        $o .= $this->loadDataAndLabelsTreeMap($data);

        $o .= "// Instantiate our object.
        var vis = new drasticdata.DrasticTreemap(document.getElementById('$name'));";

        $o .= "// Draw the treemap with the data we created locally and some options:
            vis.draw(data, {\n
                groupbycol: 'Type',\n
                labelcol: 'Module',\n
                variables: ['2010/11', '2011/12', '2012/13']\n
                }
            );
           }";
        $o .= '</script>';

        return $o;
    }


    /**
     * Returns javascript that adds the data and label to be used in the visualization.
     *
     * @param array $data
     * @param string $graph_type
     * @return string
     */
    protected function loadDataAndLabelsTreeMap($data) {
        $o = '';
        foreach($data['labels'] as $label) {
            foreach($label as $type => $label_name) {
                $o.= "data.addColumn('$type', '$label_name');\n";
            }
        }
        $data_count = count($data['data']);
        $label_count = count($data['labels']);
        $o.= "data.addRows([\n";
        for($i = 0; $i < $data_count; $i++) {
            $o.= "[";
            for($j=0; $j < $label_count; $j++) {
                $value = $data['data'][$i][$j];
                $type = key($data['labels'][$j]);
                if($type == 'string') {
                    $o.= "'$value'";
                } else {
                    $o.= "$value";
                }
                if($j !== ($label_count - 1)) {
                    $o.= ",";
                }
            }
            $o.= "],\n";
        }
        $o.= "]);\n";
        return $o;
    }






}