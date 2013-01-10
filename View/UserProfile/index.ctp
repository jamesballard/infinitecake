<table class="table table-striped" style="width:200px">
    <tr><th>ID</th><td><?php echo $userid ?></td></tr>
</table>
<?php
echo $this->autoCompleteRemote->init('ActionUser','People/jsonfeed');

echo '<div class="ui-widget" style="width:400px">';

echo $this->Form->create();

echo $this->Form->input( 'userid', array( 'type' => 'hidden') ); 
echo $this->Form->input('user', array('default' => $userid));

/*echo $this->Chosen->select(
    'user',
    $users,
    array('data-placeholder' => 'Select user...', 'default' => $user, 'deselect' => true)
);*/

echo $this->Form->end('Change');

echo '</div>';
?>
