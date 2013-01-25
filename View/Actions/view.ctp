<?php $this->layout = 'configManage'; ?>
<div class="actions view">
<h2><?php  echo __('Action'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($action['Action']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($action['Action']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($action['Action']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time'); ?></dt>
		<dd>
			<?php echo h($action['Action']['time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($action['Action']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Id'); ?></dt>
		<dd>
			<?php echo h($action['Action']['group_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Module Id'); ?></dt>
		<dd>
			<?php echo h($action['Action']['module_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
