<?php $this->layout = 'configManage'; ?>
<div class="modules view">
<h2 class="pull-left"><?php  echo __('Module'); ?></h2>
	<?php echo $this->element('actionButton', array(
								'id' => $module['Module']['id'],
								'customer_id' => h($module['System']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($module['Module']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysid'); ?></dt>
		<dd>
			<?php echo h($module['Module']['sysid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd>
			<?php echo h($module['Module']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($module['Module']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artefact'); ?></dt>
		<dd>
			<?php echo h($module['Artefact']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($module['Group']['idnumber'], array('controller' => 'groups', 'action' => 'view', $module['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd>
			<?php echo $this->Html->link($module['System']['name'], array('controller' => 'systems', 'action' => 'view', $module['System']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>