<div class="departments form">
<h2><?php echo __('Edit Department'); ?></h2>
<?php echo $this->Form->create('Department'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('active');
        echo $this->element('customerIdHidden');
        echo $this->Form->label('parent_id', 'Parent');
        echo $this->Chosen->select('parent_id',$departments,array('data-placeholder' => "Select Parent..."));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
