<?php 

$is_admin = $this->Permissions->is_admin($current_user);

if($is_admin):
	echo '<th>'.$this->Paginator->sort('customer_id').'</th>';
endif;

?>