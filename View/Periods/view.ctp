<div class="periods view">
<h2 class="pull-left"><?php  echo __('Period'); ?></h2>
<?php echo $this->element('Buttons/action', array(
        'id' => $period['Period']['id'],
        'customer_id' => 1,
        'current_user' => $current_user,
        'delete' => false,
        'offset' => true
    ));
    ?>    <dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Interval'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['interval']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($period['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $period['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($period['Period']['modified']); ?>
			&nbsp;
		</dd>
    </dl>
</div>
