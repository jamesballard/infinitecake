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
				  <h2>Analyse</h2>
				  <p>Use keys metrics to explore how student activity can help identify and promote effective teaching practices from three perspectives.</p>
				  <p class="inline">
				      <a href="/Stats" class="btn btn-primary btn-large">
				        Site
				      </a>
                      <a href="/Courseprofile" class="btn btn-primary btn-large">
                          Course
                      </a>
                      <a href="/Userprofile" class="btn btn-primary btn-large">
                          User
                      </a>
				  </p>
				</div>
	          </div>
	          <div class="span4 hero-unit analytics">
	          	<div class="">
				  <h2>Develop</h2>
				  <p>Create and develop your own metrics to understand the role that analytics can play in learning design, feedback and assessment.</p>
				  <p>
                     <?php if(in_array($current_user['Membership']['id'], array(1,2))) : ?>
                        <a href="/Rules" class="btn btn-primary btn-large">
                          Configuration
                        </a>
                     <?php else : ?>
                        <a href="#" class="btn btn-primary btn-large disabled">
                            Contact Admin
                        </a>
                     <?php endif; ?>
				  </p>
				</div>
	          </div>
	          <div class="span4 hero-unit analytics">
	          	<div class="">
				  <h2>Share</h2>
				  <p>Collaborate across systems and institutions to see how student contributions can provide dynamic indications of success.</p>
				  <p>
				    <a href="#" class="btn btn-primary btn-large disabled">
				      Coming Soon
				    </a>
				  </p>
				</div>
	          </div>
	      </div>
	    </div>
	<?php } ?>
  </div>
</div>