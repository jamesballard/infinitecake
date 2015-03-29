<?php $url = $this->request->here;
if (!preg_match("/help/", $url)): ?>
    <li><i class="icon-question-sign"></i> <?php echo $this->Html->link('Help', array('controller' => $this->name, 'action' => 'help')); ?></li>
<?php endif; ?>