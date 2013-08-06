<?php

$this->start('sidebar');
echo $this->element('Sidebars/reports');
echo $this->element('Sidebars/help');
$this->end();

echo $this->element('Reports/modules');

?>
