<?php $this->layout = 'homepage'; ?>
<h2><?php __('Reset password'); ?></h2>

<?php
echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'reset')));
?>
<fieldset>
    <legend><?php echo __('New password'); ?></legend>
    <?php
    echo $this->Form->input('Member.password');
    echo $this->Form->input('Member.password_confirm', array('type' => 'password'));
    ?>
</fieldset>
<?php
echo $this->Form->end(array('label' => __('Save')));
?>