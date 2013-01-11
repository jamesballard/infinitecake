<?php

$this->start('sidebar');
echo $this->element('reportSidebar');
echo $this->element('helpSidebar');
$this->end();

echo $this->element('tasktypeReport');

?>

