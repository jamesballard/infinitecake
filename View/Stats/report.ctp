<?php

$this->start('sidebar');
echo $this->element('Sidebars/reports');
echo $this->element('Sidebars/help');
$this->end();

//debug($report);
//debug($data);

echo $this->Html->script('zingchart-html5-min');
echo $this->Html->script('license');
echo $this->zingCharts->addZingChart('myChart', $report, $data);
echo $this->zingCharts->start('myChart');

?>