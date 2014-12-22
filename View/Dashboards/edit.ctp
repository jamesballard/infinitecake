<div class="dashboards form">
    <h2><?php echo __('Edit Dashboard'); ?></h2>
<?php echo $this->Form->create('Dashboard'); ?>
	<fieldset>
        <?php echo $this->element('FormItems/legendChangeSettings'); ?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('layout');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('Report');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>