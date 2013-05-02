<div class="groups form">
<h2><?php echo __('Edit Group'); ?></h2>
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
        echo $this->element('courseMultiSelect');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
