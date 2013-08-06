<div class="people view">
<h2 class="pull-left"><?php  echo __('Person'); ?></h2>
	<?php echo $this->element('Buttons/action', array(
								'id' => $person['Person']['id'],
								'customer_id' => h($person['Person']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Firstname'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['firstname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastname'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['lastname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dob'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['dob']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nationality'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['nationality']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ethnicity'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['ethnicity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Disability'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['disability']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($person['Person']['modified']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Department'); ?></dt>
        <dd>
            <?php if (!empty($person['Department'])): ?>
            <?php echo $this->Html->link(h($person['Department']['name']), array('controller' => 'departments', 'action' => 'view', h($person['Department']['id']))); ?>
            <?php endif; ?>
            &nbsp;
        </dd>
		<?php if (!empty($person['User'])): ?>
		<dt><?php echo __('Users'); ?></dt>
		<dd class="clearfix">
			<ul>
			<?php
				$i = 0;
				foreach ($person['User'] as $user): ?>
					<li><?php echo $this->Html->link($user['idnumber'].' ('.$user['System']['name'].': '.$user['sysid'].')', array('controller' => 'users', 'action' => 'view', $user['id'])); ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
        <?php if (!empty($person['Course'])): ?>
        <dt><?php echo __('Courses'); ?></dt>
        <dd class="clearfix">
            <ul>
                <?php
                $i = 0;
                foreach ($person['Course'] as $course): ?>
                    <li><?php echo $this->Html->link($course['name'].' ('.$course['idnumber'].')', array('controller' => 'courses', 'action' => 'view', $course['id'])); ?></li>
                    <?php endforeach; ?>
            </ul>
        </dd>
        <?php endif; ?>
	</dl>
</div>