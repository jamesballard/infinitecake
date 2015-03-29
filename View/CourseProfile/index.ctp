<?php

$this->start('sidebar');
if($courseid) {
	echo $this->element('Sidebars/reports');
}
echo $this->element('Sidebars/help');
$this->end();

echo $this->dynamicForms->autocomplete('ActionCourse','Courses/jsonfeed');

if(!empty($course)) {
    echo '<h2>'.$course['Course']['name'].' '.__('Dashboard').'</h2>';
}else{
    echo '<h2>'.__('Select Course').'</h2>';
}
echo '<div class="ui-widget">';

echo $this->Form->create(array( 'div' => false, 'class' => 'inline'));

echo $this->Form->input( 'courseid', array( 'type' => 'hidden', 'div' => false ) );
echo $this->Form->input('course', array('label' => false, 'default' => $coursedefault, 'div' => array('class' => 'pull-left')));

echo $this->Form->end('Change Course');

echo '</div>';
?>

<?php if(!empty($course)) : ?>
<h3>Student Activity (4 weeks)</h3>
<?php endif; ?>
<?php if(!empty($people)): ?>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
    <th><?php echo __('idnumber'); ?></th>

<?php foreach ($daterange as $date) : ?>
        <th><?php echo date('d-m',$date->format('U')+( 1 - date('w'))*24*3600); ?></th>
<?php endforeach; ?>

    </tr>
<?php foreach ($people as $person): ?>
    <tr>
    <td><?php echo $this->Html->link($person['idnumber'], array('controller' => 'UserProfile', 'action' => 'index', $person['id'])); ?></td>

<?php foreach ($daterange as $date) : ?>
        <td><?php echo $person['week'][$date->format('W')]; ?></td>
<?php endforeach; ?>

    </tr>
<?php endforeach; ?>
    </table>
<?php endif; ?>
