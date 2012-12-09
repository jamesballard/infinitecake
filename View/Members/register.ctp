<h2>Register your account</h2>
<?php
echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'register')));
echo $this->Form->input('Member.username');
echo $this->Form->input('Member.password');
echo $this->Form->end('Register');
?>