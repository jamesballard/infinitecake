<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (Configure::read('debug') == 0):
	throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?>
<div class="row-fluid">
  <div class="span12">
    <h3>Hi, <?php echo $current_user['Member']['firstname']; ?>!</h3>
    
    <?php
    //Print the main analytics navigation for all user 
    if(in_array($current_user['Membership']['id'], array(1,2,3))) { ?>
	    <div class="row-fluid">	
	        <div class="row-fluid">
	          <div class="span4 hero-unit analytics">
	          	<div class="">
				  <h2>Site</h2>
				  <p>View overall site reports</p>
				  <p>
				    <a href="/Stats" class="btn btn-primary btn-large">
				      View
				    </a>
				  </p>
				</div>
	          </div>
	          <div class="span4 hero-unit analytics">
	          	<div class="">
				  <h2>Course</h2>
				  <p>Individual course profiles.</p>
				  <p>
				    <a href="/Courseprofile" class="btn btn-primary btn-large">
				      View
				    </a>
				  </p>
				</div>
	          </div>
	          <div class="span4 hero-unit analytics">
	          	<div class="">
				  <h2>User</h2>
				  <p>User profiles</p>
				  <p>
				    <a href="/Userprofile" class="btn btn-primary btn-large">
				      View
				    </a>
				  </p>
				</div>
	          </div>
	      </div>
	    </div>
	<?php } ?>
	
	
    <?php
    //Print the configuration management navigation for admin and managers 
    if(in_array($current_user['Membership']['id'], array(1,2))) { ?>
	    <div class="row-fluid">	
	      <div class="span8 well well-small">
	        <h4>Configure Reports</h4>
	        <div class="row-fluid">
	          <div class="span6 well well-large"><?php echo $this->Html->link('Rules', '/Rules', array('class' => 'btn')); ?></div>
	          <div class="span6 well well-large"><?php echo $this->Html->link('Conditions', '/Conditions', array('class' => 'btn')); ?></div>
	        </div>
	      </div>
	      <div class="span4 well well-small">
	        <h4>Add Accounts</h4>
	        <div class="row-fluid">
	          <div class="span12 well well-large"><?php echo $this->Html->link('Members', '/Members', array('class' => 'btn')); ?></div>
	        </div>
	      </div>
	    </div>
	    <div class="row-fluid">	
	      <div class="span12 well well-small">
	        <h4>Manage System Data</h4>
	        <div class="row-fluid">
	          <div class="span3 well well-large"><?php echo $this->Html->link('Systems', '/Systems', array('class' => 'btn')); ?></div>
	          <div class="span3 well well-large"><?php echo $this->Html->link('Users', '/Users', array('class' => 'btn')); ?></div>
	          <div class="span3 well well-large"><?php echo $this->Html->link('Groups', '/Groups', array('class' => 'btn')); ?></div>
	          <div class="span3 well well-large"><?php echo $this->Html->link('Modules', '/Modules', array('class' => 'btn')); ?></div>
	        </div>
	      </div>
	    </div>
	<?php } ?>
	
	<?php 
	//Print the administration navigation for admin only
    if(in_array($current_user['Membership']['id'], array(1))) { ?>
	    <div class="row-fluid">	
	      <div class="span12 well">
	        <h4>Adminsitration</h4>
	        <div class="row-fluid">
	          <div class="span3 well well-large"><?php echo $this->Html->link('Customers', '/Customers', array('class' => 'btn')); ?></div>
	          <div class="span3 well well-large"><?php echo $this->Html->link('Memberships', '/Memberships', array('class' => 'btn')); ?></div>
	          <div class="span3 well well-large"><?php echo $this->Html->link('Artefacts', '/Artefacts', array('class' => 'btn')); ?></div>
	          <div class="span3 well well-large"><?php echo $this->Html->link('Verbs', '/DimensionVerbs', array('class' => 'btn')); ?></div>
	        </div>
	      </div>
	    </div>
	<?php } ?>
	
  </div>
</div>