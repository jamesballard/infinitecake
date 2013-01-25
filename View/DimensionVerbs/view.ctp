<div class="dimensionVerbs view">
<h2><?php  echo __('Dimension Verb'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysname'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['sysname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uri'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['uri']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artefact'); ?></dt>
		<dd>
			<?php echo $this->Html->link($dimensionVerb['Artefact']['name'], array('controller' => 'artefacts', 'action' => 'view', $dimensionVerb['Artefact']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dimension Verb'), array('action' => 'edit', $dimensionVerb['DimensionVerb']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dimension Verb'), array('action' => 'delete', $dimensionVerb['DimensionVerb']['id']), null, __('Are you sure you want to delete # %s?', $dimensionVerb['DimensionVerb']['id'])); ?> </li>
	</ul>
</div>
