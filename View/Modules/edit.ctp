<div class="modules form">
<h2><?php echo __('Edit Module'); ?></h2>
<?php echo $this->Form->create('Module'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
        echo $this->Form->input('id');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>