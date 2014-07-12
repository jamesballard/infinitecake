<?php
echo $this->Html->script('zingchart-html5-min');
echo $this->Html->script('license');
echo $this->zingCharts->addZingChart('myChart', $report, $data, '90%', '98%');
echo $this->zingCharts->start('myChart');
?>