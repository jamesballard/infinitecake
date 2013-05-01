<table class="table table-striped" style="width:200px">
<tr><th>ID</th><td><?php echo $courseid ?></td></tr>
</table>
<?php

$this->start('sidebar');
if($courseid) {
	echo $this->element('reportSidebar');
}
echo $this->element('helpSidebar');
$this->end();

echo $this->autoCompleteRemote->init('ActionCourse','Courses/jsonfeed');

echo '<div class="ui-widget" style="width:400px">';

echo $this->Form->create();

echo $this->Form->input( 'courseid', array( 'type' => 'hidden' ) );
echo $this->Form->input('course', array('default' => $coursedefault));

echo $this->Form->end('Change');

echo '</div>';
?>
