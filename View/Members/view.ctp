<div class="members view">
<h2 class="pull-left"><?php  echo __('Member'); ?></h2>
	<?php echo $this->element('Buttons/action', array(
								'id' => $member['Member']['id'],
								'customer_id' => h($member['Member']['customer_id']),
								'current_user' => $current_user,
								'delete' => true,
								'offset' => true
							)); 
	?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Member']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Member']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Firstname'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Member']['firstname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastname'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Member']['lastname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Membership'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Membership']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Member']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($member['Member']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
