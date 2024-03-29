<div class="users view">
<h2 class="pull-left"><?php  echo __('User'); ?></h2>
	<?php echo $this->element('Buttons/action', array(
								'id' => $user['User']['id'],
								'customer_id' => h($user['System']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysid'); ?></dt>
		<dd class="clearfix">
			<?php echo h($user['User']['sysid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd class="clearfix">
			<?php echo h($user['User']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Person'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($user['Person']['idnumber'], array('controller' => 'people', 'action' => 'view', $user['Person']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($user['System']['name'], array('controller' => 'systems', 'action' => 'view', $user['System']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
