<?php
echo $this->Form->input('period', array(
    'options' => array('day' => 'day', 'week' => 'week', 'month' => 'month'),
    'default' => 'month'
));
?>