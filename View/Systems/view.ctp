<?php $this->layout = 'configManage'; ?>
<div class="systems view">
<h2 class="pull-left"><?php  echo __('System'); ?></h2>
	<?php echo $this->element('actionButton', array(
								'id' => $system['System']['id'],
								'customer_id' => h($system['System']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($system['System']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo $system_types[h($system['System']['type'])]; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($system['System']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Certificate'); ?></dt>
		<dd>
			<?php echo h($system['System']['certificate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Site Name'); ?></dt>
		<dd>
			<?php echo h($system['System']['site_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Email'); ?></dt>
		<dd>
			<?php echo h($system['System']['contact_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($system['System']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($system['System']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
