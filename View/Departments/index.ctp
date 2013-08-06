<div class="departments index">
	<h2 class="pull-left"><?php echo __('Departments'); ?></h2>
    <?php
    echo $this->element('Buttons/add',array(
            'current_user' => $current_user,
            'add' => true
        )
    );

    $this->RecursiveDepartments->RecursiveDepartments($departments);