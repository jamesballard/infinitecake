<div class="dashboards view">
<h2 class="pull-left"><?php  echo __('Dashboard'); ?></h2>
<?php echo $this->element('Buttons/action', array(
        'id' => $dashboard['Dashboard']['id'],
        'customer_id' => 1,
        'current_user' => $current_user,
        'delete' => false,
        'offset' => true
    ));
    ?>    <dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($dashboard['Dashboard']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($dashboard['Dashboard']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Layout'); ?></dt>
		<dd class="clearfix">
			<?php echo h($dashboard['Dashboard']['layout']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($dashboard['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $dashboard['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($dashboard['Dashboard']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($dashboard['Dashboard']['modified']); ?>
			&nbsp;
		</dd>
    <?php if (!empty($dashboard['Report'])): ?>
    <dt><?php echo __('Related Reports'); ?></dt>
        <dd class="clearfix">
            <ul>
	<?php
		foreach ($dashboard['Report'] as $report): ?>
		<li>
				<?php echo $this->Html->link($report['name'], array('controller' => 'reports', 'action' => 'view', $report['id'])); ?>
		</li>
	<?php endforeach; ?>
            </ul>
        </dd>
<?php endif; ?>

    </dl>
</div>
