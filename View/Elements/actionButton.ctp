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
			  		echo '<li>'.$this->Html->link('<i class="icon-eye-open"></i> '.__('View'), array('action' => 'view', $id), array('escape' => FALSE)).'</li>';
			  	endif;
			  	
			  	if($is_customer || $is_admin): 
			  		echo '<li>'.$this->Html->link('<i class="icon-edit"></i> '.__('Edit'), array('action' => 'edit', $id), array('escape' => FALSE)).'</li>';
			  		if($delete || $is_admin):
			  			echo '<li>'.$this->Form->postLink('<i class="icon-remove-sign"></i> '.__('Delete'), array('action' => 'delete', $id), array('escape' => FALSE), __('Are you sure you want to delete # %s?', $id)).'</li>';
			  		endif;
			  	endif;
			  	echo '</ul>';
			endif;
	  ?>
</div>
<div class="clearfix"></div>