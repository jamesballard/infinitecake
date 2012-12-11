<div class="dirobjects view">
<h2><?php  echo __('Dirobject'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dirobject['Dirobject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd>
			<?php echo h($dirobject['Dirobject']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($dirobject['Dirobject']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artefact Id'); ?></dt>
		<dd>
			<?php echo h($dirobject['Dirobject']['artefact_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($dirobject['Dirobject']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($dirobject['Dirobject']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dirobject'), array('action' => 'edit', $dirobject['Dirobject']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dirobject'), array('action' => 'delete', $dirobject['Dirobject']['id']), null, __('Are you sure you want to delete # %s?', $dirobject['Dirobject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dirobjects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dirobject'), array('action' => 'add')); ?> </li>
	</ul>
</div>
