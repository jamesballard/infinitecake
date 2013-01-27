<?php $this->layout = 'configManage'; ?>
<div class="systems form">
<h2><?php echo __('Edit System'); ?></h2>
<?php echo $this->Form->create('System'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type', array('options' => $system_types));
		echo $this->Form->input('name');
    ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>