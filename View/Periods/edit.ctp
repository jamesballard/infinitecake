<div class="periods form">
    <h2><?php echo __('Edit Period'); ?></h2>
<?php echo $this->BootstrapForm->create('Period'); ?>
	<fieldset>
        <?php echo $this->element('FormItems/legendChangeSettings'); ?>
	<?php
		echo $this->Form->input('id');
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