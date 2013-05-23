<div class="groups view">
<h2 class="pull-left"><?php  echo __('Group'); ?></h2>
	<?php echo $this->element('actionButton', array(
								'id' => $group['Group']['id'],
								'customer_id' => h($group['System']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysid'); ?></dt>
		<dd class="clearfix">
			<?php echo h($group['Group']['sysid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd class="clearfix">
			<?php echo h($group['Group']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd class="clearfix">
			<?php echo $group_types[h($group['Group']['type'])]; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($group['System']['name'], array('controller' => 'systems', 'action' => 'view', $group['System']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
