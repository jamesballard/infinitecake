<?php $this->layout = 'configManage'; ?>
<div class="people view">
<h2 class="pull-left"><?php  echo __('Person'); ?></h2>
	<?php echo $this->element('actionButton', array(
								'id' => $person['Person']['id'],
								'customer_id' => h($person['Person']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
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
		
		<?php if (!empty($person['User'])): ?>
		<dt><?php echo __('Users'); ?></dt>
		<dd>
			<ul>
			<?php
				$i = 0;
				foreach ($person['User'] as $user): ?>
					<li><?php echo $this->Html->link($user['idnumber'].' ('.$user['System']['name'].': '.$user['sysid'].')', array('controller' => 'users', 'action' => 'view', $user['id'])); ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
		
	</dl>
</div>