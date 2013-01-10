<table class="table table-striped" style="width:200px">
<tr><th>ID</th><td><?php echo $groupid ?></td></tr>
</table>
<?php

$this->start('sidebar');
if($groupid) {
	echo $this->element('reportSidebar');
}
echo $this->element('helpSidebar');
$this->end();

echo $this->autoCompleteRemote->init('ActionGroup','Groups/jsonfeed');

echo '<div class="ui-widget" style="width:400px">';

echo $this->Form->create();

echo $this->Form->input( 'groupid', array( 'type' => 'hidden' ) ); 
echo $this->Form->input('group', array('default' => $groupdefault));

echo $this->Form->end('Change');

echo '</div>';
?>
