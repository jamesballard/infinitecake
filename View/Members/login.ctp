<?php $this->layout = 'homepage'; ?>
<h2>Welcome</h2>
<?php
echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'login')));
?>
<fieldset>
    <legend><?php echo __('Login'); ?></legend>
<?php
echo $this->Form->input('Member.email');
echo $this->Form->input('Member.password');
?>
</fieldset>
<?php
echo $this->Form->end(array('label' => __('Login')));
?>
<div class="col-md-offset-2">
    <i class="fa fa-rebel"></i>
<?php echo $this->Html->link("Forgot your password? Click here.", array("controller" => "members", "action" => "forgotpwd")); ?>
</div>