<div class="customers view">
	<h2 class="pull-left"><?php  echo __('Customer'); ?></h2>
	<?php echo $this->element('Buttons/action', array(
								'id' => $customer['Customer']['id'],
								'customer_id' => h($customer['Customer']['id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
			?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lon'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['lon']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($customer['Customer']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
