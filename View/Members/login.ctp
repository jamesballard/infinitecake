<?php $this->layout = 'homepage'; ?>
<h2>Login</h2>
<?php
echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'login')));
echo $this->Form->input('Member.username');
echo $this->Form->input('Member.password');
echo $this->Form->end('Login');
?>