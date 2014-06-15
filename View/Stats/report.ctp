<?php

$this->start('sidebar');
echo $this->element('Sidebars/reports');
echo $this->element('Sidebars/help');
$this->end();

//debug($report);
//debug($data);

echo '<h2>'.$report['Report']['name'].'</h2>';

echo $this->Html->script('zingchart-html5-min');
echo $this->Html->script('license');
echo $this->zingCharts->addZingChart('myChart', $report, $data, '90%', '98%');
echo $this->zingCharts->start('myChart');

?>