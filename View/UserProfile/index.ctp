<table style="width:200px">
    <tr><th>ID</th><td><?php echo $user ?></td></tr>
</table>
<?php

echo '<div style="width:400px">';

echo $this->Form->create();

echo $this->Chosen->select(
    'user',
    $users,
    array('data-placeholder' => 'Select user...', 'deselect' => true)
);

echo $this->Form->end('Change');

echo '</div>';
?>
