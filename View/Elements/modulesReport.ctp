<?php

echo $this->DrasticTreeMap->init('chart_div');
echo $this->DrasticTreeMap->visualize('chart_div', $data);

echo '<div id="chart_div"  style="width:'.$width.'px; height:'.$height.'px;"></div>';

echo '<div style="width:400px">';

echo $this->Form->create();
echo $this->element('dateWindowSelect');
echo $this->element('systemMultiSelect');
echo $this->element('sizeInput');

echo $this->Form->end('Change');

echo '</div>';

?>
