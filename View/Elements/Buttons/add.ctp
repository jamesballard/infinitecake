<?php 
$is_admin = $this->Permissions->is_admin($current_user);
$wizards = array('Rules');
$url = $this->request->here;

$action = 'add';
foreach($wizards as $wizard) {
    if(preg_match("/$wizard/", $url)) {
        $action = 'wizard';
    }
}
?>
<?php
    if(!$add && !$is_admin):
        echo '<a href="#" class="btn btn-default btn-offset disabled">';
        echo '<span class="glyphicon glyphicon-plus-sign lblue"></span> '.__('Create').'</a>';
    else:
        echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign lblue"></span> '.__('Create'),
            array('action' => $action), array('class'=>'btn btn-default btn-offset', 'escape' => FALSE));
    endif;
?>
<div class="clearfix"></div>