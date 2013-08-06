<div class="systems view">
<h2 class="pull-left"><?php  echo __('System'); ?></h2>
	<?php echo $this->element('Buttons/action', array(
								'id' => $system['System']['id'],
								'customer_id' => h($system['System']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd class="clearfix">
			<?php echo $system_types[h($system['System']['type'])]; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Certificate'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['certificate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Site Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['site_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Email'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['contact_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($system['System']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
