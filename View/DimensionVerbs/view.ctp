<div class="dimensionVerbs view">
<h2 class="pull-left"><?php  echo __('Dimension Verb'); ?></h2>
	<?php echo $this->element('actionButton', array(
								'id' => $dimensionVerb['DimensionVerb']['id'],
								'customer_id' => 1,
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
			?>
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
			<?php echo $verb_types[h($dimensionVerb['DimensionVerb']['type'])]; ?>
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