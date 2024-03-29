<div class="departments view">
<h2 class="pull-left"><?php  echo __('Department'); ?></h2>
    <?php echo $this->element('Buttons/action', array(
            'id' => $department['Department']['id'],
            'customer_id' => h($department['Department']['customer_id']),
            'current_user' => $current_user,
            'delete' => true,
            'offset' => true
        ));
    ?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($department['Department']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($department['Department']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd class="clearfix">
			<?php echo h($department['Department']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd class="clearfix">
			<?php echo h($department['Department']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent'); ?></dt>
		<dd class="clearfix">
			<?php
             if (!empty($parent)):
                echo $this->Html->link($parent['Department']['name'], array('controller' => 'departments', 'action' => 'view', $parent['Department']['id']));
             endif;
            ?>
            &nbsp;
		</dd>
	    <dt><?php echo __('Courses'); ?></dt>
        <dd class="clearfix">
	        <?php
                if (!empty($department['Course'])):
                    $i = 0;
                    echo '<ul>';
                    foreach ($department['Course'] as $course):
                        echo '<li>';
                        echo $this->Html->link($course['idnumber'], array('controller' => 'courses', 'action' => 'view', $course['id']));
                        echo '</li>';
                    endforeach;
                    echo '<ul>';
                endif;
            ?>
        </dd>
	</dl>
</div>

