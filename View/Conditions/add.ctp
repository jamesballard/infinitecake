<?php $this->layout = 'configManage'; ?>
<div class="conditions form">
<h2><?php echo __("Add $label Condition"); ?></h2>
<?php echo $this->Form->create('Condition'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('type', array( 'value' => Condition::CONDITION_TYPE_USER , 'type' => 'hidden') );
		echo $this->Form->input('Rule');
		if($formid != 'Action') {
        	echo $this->element('conditionItemsMultiSelect');
        }
        echo $this->element('customerIdHidden');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
