<?php $this->layout = 'homepage'; ?>
<h2>Welcome</h2>
<?php
echo $this->BootstrapForm->create('Member', array('url' => array('controller' => 'members', 'action' => 'login')));
?>
<fieldset>
    <legend><?php echo __('Login'); ?></legend>
<?php
echo $this->Form->input('Member.username');
echo $this->Form->input('Member.password');
?>
</fieldset>
<?php
echo $this->BootstrapForm->end(__('Login'));
?>