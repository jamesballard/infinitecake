<div class="rules form">
<h2><?php echo __('Add Classification'); ?></h2>
<?php echo $this->Form->create('Rule'); ?>
	<fieldset>
	<?php
        echo '<legend>'.__('Add existing items').'</legend>';
        echo '<p>Use this menu to re-use existing items with this rule.</p>';
        echo $this->Form->input('id');
        echo $this->element('MultiSelectForms/conditions');
	?>
	</fieldset>
    <?php echo $this->Form->end(array('label' => __('Continue'))); ?>
</div>