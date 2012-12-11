<div class="artefacts view">
<h2><?php  echo __('Artefact'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Community Id'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['community_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($artefact['Artefact']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Artefact'), array('action' => 'edit', $artefact['Artefact']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Artefact'), array('action' => 'delete', $artefact['Artefact']['id']), null, __('Are you sure you want to delete # %s?', $artefact['Artefact']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artefact'), array('action' => 'add')); ?> </li>
	</ul>
</div>
