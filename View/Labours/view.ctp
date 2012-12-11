<div class="labours view">
<h2><?php  echo __('Labour'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Person Id'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['person_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Community Id'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['community_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($labour['Labour']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Labour'), array('action' => 'edit', $labour['Labour']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Labour'), array('action' => 'delete', $labour['Labour']['id']), null, __('Are you sure you want to delete # %s?', $labour['Labour']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Labours'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Labour'), array('action' => 'add')); ?> </li>
	</ul>
</div>
