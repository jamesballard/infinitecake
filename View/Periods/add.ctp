<div class="periods form">
    <h2><?php echo __('Add Period'); ?></h2>
<?php echo $this->Form->create('Period'); ?>
	<fieldset>
        <?php echo $this->element('FormItems/legendSettings'); ?>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('start', array(
            'type' => 'text',
            'label' => __('Start'),
            'class' => 'form-control datepicker',
            'placeholder' => 'dd/mm/yyyy'
        ));
		echo $this->Form->input('end', array(
            'type' => 'text',
            'label' => __('End'),
            'class' => 'form-control datepicker',
            'placeholder' => 'dd/mm/yyyy'
        ));
		echo $this->Form->input('interval', array(
            'options' => $intervals,
            'default' => Period::PERIOD_INTERVAL_YEAR)
        );
		echo $this->Form->input('customer_id');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>