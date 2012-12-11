<div class="communities view">
<h2><?php  echo __('Community'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($community['Community']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd>
			<?php echo h($community['Community']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($community['Community']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($community['Community']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Id'); ?></dt>
		<dd>
			<?php echo h($community['Community']['customer_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($community['Community']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($community['Community']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Community'), array('action' => 'edit', $community['Community']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Community'), array('action' => 'delete', $community['Community']['id']), null, __('Are you sure you want to delete # %s?', $community['Community']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Communities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Community'), array('action' => 'add')); ?> </li>
	</ul>
</div>
