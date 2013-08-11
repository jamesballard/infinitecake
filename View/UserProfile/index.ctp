<table class="table table-striped" style="width:200px">
    <tr><th>ID</th><td><?php echo $userid ?></td></tr>
</table>
<?php

$this->start('sidebar');
if($userid) {
	echo $this->element('Sidebars/reports');
}
echo $this->element('Sidebars/help');
$this->end();

echo $this->dynamicForms->autocomplete('ActionUser','People/jsonfeed');

echo '<div class="ui-widget" style="width:400px">';

echo $this->Form->create();

echo $this->Form->input( 'userid', array( 'type' => 'hidden' ) ); 
echo $this->Form->input('user', array('default' => $userdefault));

echo $this->Form->end('Change');

echo '</div>';
?>
