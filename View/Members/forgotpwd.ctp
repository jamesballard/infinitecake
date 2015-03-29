<?php $this->layout = 'homepage'; ?>
<h2><?php __('Forget password'); ?></h2>

<?php
echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'forgotpwd')));
?>
<fieldset>
    <legend><?php echo __('Confirm email'); ?></legend>
    <?php
    echo $this->Form->input('Member.email');
    ?>
</fieldset>
<?php
echo $this->Form->end(array('label' => __('Recover')));
?>