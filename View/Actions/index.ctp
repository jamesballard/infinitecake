<div class="actions index">
	<h2 class="pull-left"><?php echo __('Actions'); ?></h2>
    <?php
    echo $this->element('Buttons/add',array(
            'current_user' => $current_user,
            'add' => false
        )
    );
    ?>	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('sysid'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('time'); ?></th>
			<th><?php echo $this->Paginator->sort('system_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('module_id'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('dimension_verb_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($actions as $action): ?>
	<tr>
		<td><?php echo h($action['Action']['id']); ?>&nbsp;</td>
		<td><?php echo h($action['Action']['sysid']); ?>&nbsp;</td>
		<td><?php echo h($action['Action']['name']); ?>&nbsp;</td>
		<td><?php echo h($action['Action']['time']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($action['System']['name'], array('controller' => 'systems', 'action' => 'view', $action['System']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($action['User']['idnumber'], array('controller' => 'users', 'action' => 'view', $action['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($action['Module']['name'], array('controller' => 'modules', 'action' => 'view', $action['Module']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($action['Group']['name'], array('controller' => 'groups', 'action' => 'view', $action['Group']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($action['DimensionVerb']['name'], array('controller' => 'dimension_verbs', 'action' => 'view', $action['DimensionVerb']['id'])); ?>
		</td>
		<td>
<?php echo $this->element('Buttons/action', array(
                'id' => $action['Action']['id'],
                'customer_id' => 1,
                'current_user' => $current_user,
                'delete' => false,
                'offset' => false
            ));
            ?>		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
