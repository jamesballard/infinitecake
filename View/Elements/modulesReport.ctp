<?php

echo $this->DrasticTreeMap->init('chart_div');
echo $this->DrasticTreeMap->visualize('chart_div', $data);

echo '<div id="chart_div"  style="width:'.$width.'px; height:'.$height.'px;"></div>';

echo '<div style="width:400px">';

echo $this->Form->create();

echo $this->Form->input('system', array(
    'options' => $systems,
    'default' => 0
));

echo $this->Form->input('width', array(
        'type' => 'text',
        'default' => '750'
    )
); // has a label element

echo $this->Form->input('height', array(
        'type' => 'text',
        'default' => '500'
    )
); // has a label element

echo $this->Form->end('Change');

echo '</div>';

?>
