<div class="people view">
<h2><?php  echo __('Person'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($person['Person']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Firstname'); ?></dt>
		<dd>
			<?php echo h($person['Person']['firstname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastname'); ?></dt>
		<dd>
			<?php echo h($person['Person']['lastname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($person['Person']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dob'); ?></dt>
		<dd>
			<?php echo h($person['Person']['dob']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nationality'); ?></dt>
		<dd>
			<?php echo h($person['Person']['nationality']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ethnicity'); ?></dt>
		<dd>
			<?php echo h($person['Person']['ethnicity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Disability'); ?></dt>
		<dd>
			<?php echo h($person['Person']['disability']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($person['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $person['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($person['Person']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($person['Person']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Person'), array('action' => 'edit', $person['Person']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Person'), array('action' => 'delete', $person['Person']['id']), null, __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Labours'), array('controller' => 'labours', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Labour'), array('controller' => 'labours', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Rules'), array('controller' => 'rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rule'), array('controller' => 'rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Communities'), array('controller' => 'communities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Community'), array('controller' => 'communities', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Labours'); ?></h3>
	<?php if (!empty($person['Labour'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Idnumber'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Person Id'); ?></th>
		<th><?php echo __('Community Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($person['Labour'] as $labour): ?>
		<tr>
			<td><?php echo $labour['id']; ?></td>
			<td><?php echo $labour['idnumber']; ?></td>
			<td><?php echo $labour['name']; ?></td>
			<td><?php echo $labour['person_id']; ?></td>
			<td><?php echo $labour['community_id']; ?></td>
			<td><?php echo $labour['created']; ?></td>
			<td><?php echo $labour['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'labours', 'action' => 'view', $labour['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'labours', 'action' => 'edit', $labour['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'labours', 'action' => 'delete', $labour['id']), null, __('Are you sure you want to delete # %s?', $labour['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Labour'), array('controller' => 'labours', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Rules'); ?></h3>
	<?php if (!empty($person['Rule'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Artefact Id'); ?></th>
		<th><?php echo __('Community Id'); ?></th>
		<th><?php echo __('Person Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($person['Rule'] as $rule): ?>
		<tr>
			<td><?php echo $rule['id']; ?></td>
			<td><?php echo $rule['name']; ?></td>
			<td><?php echo $rule['value']; ?></td>
			<td><?php echo $rule['artefact_id']; ?></td>
			<td><?php echo $rule['community_id']; ?></td>
			<td><?php echo $rule['person_id']; ?></td>
			<td><?php echo $rule['created']; ?></td>
			<td><?php echo $rule['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'rules', 'action' => 'view', $rule['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'rules', 'action' => 'edit', $rule['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'rules', 'action' => 'delete', $rule['id']), null, __('Are you sure you want to delete # %s?', $rule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Rule'), array('controller' => 'rules', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($person['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Sysid'); ?></th>
		<th><?php echo __('Idnumber'); ?></th>
		<th><?php echo __('Person Id'); ?></th>
		<th><?php echo __('System Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($person['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['sysid']; ?></td>
			<td><?php echo $user['idnumber']; ?></td>
			<td><?php echo $user['person_id']; ?></td>
			<td><?php echo $user['system_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Communities'); ?></h3>
	<?php if (!empty($person['Community'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Idnumber'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($person['Community'] as $community): ?>
		<tr>
			<td><?php echo $community['id']; ?></td>
			<td><?php echo $community['idnumber']; ?></td>
			<td><?php echo $community['name']; ?></td>
			<td><?php echo $community['type']; ?></td>
			<td><?php echo $community['customer_id']; ?></td>
			<td><?php echo $community['created']; ?></td>
			<td><?php echo $community['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'communities', 'action' => 'view', $community['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'communities', 'action' => 'edit', $community['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'communities', 'action' => 'delete', $community['id']), null, __('Are you sure you want to delete # %s?', $community['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Community'), array('controller' => 'communities', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
