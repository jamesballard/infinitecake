<div class="courses view">
<h2 class="pull-left"><?php  echo __('Course'); ?></h2>
    <?php echo $this->element('actionButton', array(
            'id' => $course['Course']['id'],
            'customer_id' => h($course['Department']['customer_id']),
            'current_user' => $current_user,
            'delete' => true,
            'offset' => true
        ));
    ?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($course['Course']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($course['Course']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shortname'); ?></dt>
		<dd class="clearfix">
			<?php echo h($course['Course']['shortname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd class="clearfix">
			<?php echo h($course['Course']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd class="clearfix">
			<?php echo h($course['Course']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Department'); ?></dt>
		<dd class="clearfix">
			<?php echo $this->Html->link($course['Department']['name'], array('controller' => 'departments', 'action' => 'view', $course['Department']['id'])); ?>
			&nbsp;
		</dd>
	<?php if (!empty($course['Person'])): ?>
            <dt><?php echo __('People'); ?></dt>
            <dd class="clearfix">
			    <ul>
                    <?php
                    $i = 0;
		            foreach ($course['Person'] as $person): ?>
                        <li><?php echo $this->Html->link($person['idnumber'], array('controller' => 'people', 'action' => 'view', $person['id'])); ?></li>
                    <?php endforeach; ?>
                </ul>
            </dd>
        <?php endif; ?>
    </dl>
</div>
