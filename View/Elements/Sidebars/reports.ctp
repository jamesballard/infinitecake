<?php $url = $this->request->here; ?>
<li>
<?php
if(preg_match("/Userprofile/", $url)) {
	echo $this->Html->link('Select User', array('controller' => $this->name, 'action' => 'index'));
}elseif(preg_match("/Courseprofile/", $url)) {
	echo $this->Html->link('Select Course', array('controller' => $this->name, 'action' => 'index'));
}
?>
</li>
<li class="nav-header"><?php echo __('My Reports') ?></li>
<?php foreach($reports as $report) :
    $report_id = $report['Report']['id'];
?>
<li<?php echo (preg_match("(report/$report_id)", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link($report['Report']['name'],
        array('controller' => $this->name, 'action' => 'report', $report_id)); ?>
</li>
<?php endforeach; ?>
<li class="divider"></li> 