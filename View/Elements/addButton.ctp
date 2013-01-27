<?php 
$is_admin = $this->Permissions->is_admin($current_user);
?>

<div class="btn-toolbar">
	<?php 
		if(!$add && !$is_admin):
 	         echo '<a href="#" class="btn btn-offset disabled"><i class="icon-plus-sign"></i> '.__('Add new').'</a>';
 	    else:
			echo '<div class="btn-group btn-offset">';
	  		echo $this->Html->link('<i class="icon-plus-sign"></i> '.__('Add new'), array('action' => 'add'), array('class'=>'btn', 'escape' => FALSE)); 
	  	endif;	
	?>
	</div>
</div>
<div class="clearfix"></div>