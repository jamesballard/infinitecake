<?php 
$url = $this->request->here; 
$is_view = preg_match("/view/", $url);
$is_customer = $this->Permissions->check_customerID($current_user, $customer_id);
$is_admin = $this->Permissions->is_admin($current_user);

echo $this->Html->link($name, array('action' => 'view', $id));

$disabled = '';
if($is_view && !$is_customer && !$is_admin) {
    $disabled = 'disabled="disabled"';
}
if($is_customer || $is_admin):
?>
    <div class="btn-group<?php if($offset): echo ' btn-offset'; endif; ?>">
<?php
    echo '<button type="button" class="btn btn-link btn-options dropdown-toggle" '.$disabled.' data-toggle="dropdown">';
    echo '<span class="glyphicon glyphicon-collapse-down grey"></span></button>';
    echo '<span class="sr-only">Toggle Dropdown</span>';
    echo '</button>';
    echo '<ul class="dropdown-menu" role="menu">';

        echo '<li>'.$this->Html->link('<span class="glyphicon glyphicon-edit lblue"></span> '.__('Edit'), array('action' => 'edit', $id), array('escape' => FALSE)).'</li>';
        if($delete || $is_admin):
            echo '<li>'.$this->Form->postLink('<span class="glyphicon glyphicon-trash lblue"></span> '.__('Delete'), array('action' => 'delete', $id), array('escape' => FALSE), __('Are you sure you want to delete # %s?', $id)).'</li>';
        endif;
    echo '</ul>';
    endif;
?>
</div>
<div class="clearfix"></div>