<div class="rules view">
<h2><?php  echo __('Rule'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['value']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Type'); ?></dt>
        <dd>
            <?php
                switch (h($rule['Rule']['type'])) {
                    case Rule::RULE_TYPE_ACTION:
                        echo 'Action';
                        break;
                    case Rule::RULE_TYPE_ARTEFACT:
                        echo 'Artefact';
                        break;
                    case Rule::RULE_TYPE_DIMENSION_VERB:
                        echo 'Verb';
                        break;
                    case Rule::RULE_TYPE_MODULE:
                        echo 'Module';
                        break;
                }
            ?>
            &nbsp;
        </dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($rule['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $rule['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($rule['Rule']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rule'), array('action' => 'edit', $rule['Rule']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rule'), array('action' => 'delete', $rule['Rule']['id']), null, __('Are you sure you want to delete # %s?', $rule['Rule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rule'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Conditions'), array('controller' => 'conditions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Condition'), array('controller' => 'conditions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Conditions'); ?></h3>
	<?php if (!empty($rule['Condition'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($rule['Condition'] as $condition): ?>
		<tr>
			<td><?php echo $condition['id']; ?></td>
			<td><?php echo $condition['name']; ?></td>
			<td><?php echo $condition['value']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'conditions', 'action' => 'view', $condition['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'conditions', 'action' => 'edit', $condition['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'conditions', 'action' => 'delete', $condition['id']), null, __('Are you sure you want to delete # %s?', $condition['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Condition'), array('controller' => 'conditions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
