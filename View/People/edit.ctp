<div class="people form">
<h2><?php echo __('Edit Person'); ?></h2>
<?php echo $this->Form->create('Person'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('gender');
		echo $this->Form->input('dob');
		echo $this->Form->input('nationality');
		echo $this->Form->input('ethnicity');
		echo $this->Form->input('disability');
		echo $this->element('customerIdHidden');
        echo $this->element('courseMultiSelect');
		echo $this->element('userMultiSelect');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>