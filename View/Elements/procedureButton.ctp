<?php 
$url = $this->request->here; 
$is_view = preg_match("/view/", $url);
$is_customer = $this->Permissions->check_customerID($current_user, $customer_id);
$is_admin = $this->Permissions->is_admin($current_user);
?>

<div class="btn-group<?php if($offset): echo ' btn-offset'; endif; ?>">
 	<?php if($is_view && !$is_customer && !$is_admin):
 	         echo '<a href="#" class="btn disabled">'.__('Actions').'</a>';
 	      else:
			  echo '<a class="btn" href="#">'.__('Actions').'</a>';
			  echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
			  echo '<ul class="dropdown-menu">';
			  	
			  	if(!$is_view):
			  		echo '<li>'.$this->Html->link('<i class="icon-forward"></i> '.__('Run Process'), array('action' => 'trigger', $type, $rule_id), array('escape' => FALSE)).'</li>';
			  	endif;
			  	
			  	if($is_customer || $is_admin): 
			  		echo '<li>'.$this->Html->link('<i class="icon-trash"></i> '.__('Reset Data'), array('action' => 'reset', $type, $rule_id), array('escape' => FALSE)).'</li>';
			  	endif;
			  	echo '</ul>';
			endif;
	  ?>
</div>
<div class="clearfix"></div>