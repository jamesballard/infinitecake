<div class="rules form">
<h2><?php echo __('Add Report'); ?></h2>
<?php echo $this->BootstrapForm->create('Rule'); ?>
	<fieldset>
	<?php
        echo '<legend>'.__('Add existing items').'</legend>';
        echo '<p>Use this menu to re-use existing items with this rule.</p>';
        echo $this->Form->input('id');
        echo $this->element('MultiSelectForms/conditions');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>