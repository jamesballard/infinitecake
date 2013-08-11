<div class="rules form">
<h2><?php echo __('Add Rule'); ?></h2>
<?php echo $this->BootstrapForm->create('Rule'); ?>
	<fieldset>
	<?php
        echo '<legend>'.__('Add existing conditions').'</legend>';
        echo '<p>Use this menu to add existing conditions to this rule.</p>';
        echo $this->Form->input('id');
        echo $this->element('MultiSelectForms/conditions');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>