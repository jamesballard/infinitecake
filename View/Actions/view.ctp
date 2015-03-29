<div class="actions view">
<h2 class="pull-left"><?php  echo __('Action'); ?></h2>
<?php echo $this->element('Buttons/action', array(
        'id' => $action['Action']['id'],
        'customer_id' => 1,
        'current_user' => $current_user,
        'delete' => false,
        'offset' => true
    ));
    ?>    <dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($action['Action']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysid'); ?></dt>
		<dd class="clearfix">
			<?php echo h($action['Action']['sysid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($action['Action']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time'); ?></dt>
		<dd class="clearfix">
			<?php echo h($action['Action']['time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($action['System']['name'], array('controller' => 'systems', 'action' => 'view', $action['System']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($action['User']['idnumber'], array('controller' => 'users', 'action' => 'view', $action['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Module'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($action['Module']['name'], array('controller' => 'modules', 'action' => 'view', $action['Module']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($action['Group']['name'], array('controller' => 'groups', 'action' => 'view', $action['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dimension Verb'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($action['DimensionVerb']['name'], array('controller' => 'dimension_verbs', 'action' => 'view', $action['DimensionVerb']['id'])); ?>
			&nbsp;
		</dd>
    <?php if (!empty($action['Condition'])): ?>
    <dt><?php echo __('Related Conditions'); ?></dt>
        <dd class="clearfix">
            <ul>
	<?php
		foreach ($action['Condition'] as $condition): ?>
		<li>
				<?php echo $this->Html->link($condition['name'], array('controller' => 'conditions', 'action' => 'view', $condition['id'])); ?>
		</li>
	<?php endforeach; ?>
            </ul>
        </dd>
<?php endif; ?>

    </dl>
</div>
