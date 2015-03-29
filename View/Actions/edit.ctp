<div class="actions form">
    <h2><?php echo __('Edit Action'); ?></h2>
<?php echo $this->Form->create('Action'); ?>
	<fieldset>
        <?php echo $this->element('FormItems/legendChangeSettings'); ?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sysid');
		echo $this->Form->input('name');
		echo $this->Form->input('time');
		echo $this->Form->input('system_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('module_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('dimension_verb_id');
		echo $this->Form->input('Condition');
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>