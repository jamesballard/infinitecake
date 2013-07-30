<div class="memberships view">
<h2><?php  echo __('Membership'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($membership['Membership']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($membership['Membership']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($membership['Membership']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($membership['Membership']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
