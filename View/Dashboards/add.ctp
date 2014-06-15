<div class="dashboards form">
    <h2><?php echo __('Add Dashboard'); ?></h2>
<?php echo $this->BootstrapForm->create('Dashboard'); ?>
	<fieldset>
        <?php echo $this->element('FormItems/legendSettings'); ?>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('layout');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('Report');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>