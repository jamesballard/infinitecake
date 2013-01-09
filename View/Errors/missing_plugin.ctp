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
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="alert alert-error">
<h4><?php echo __d('cake_dev', 'Missing Plugin'); ?></h4>
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'The application is trying to load a file from the %s plugin', '<em>' . $plugin . '</em>'); ?>
</div>
<div class="alert alert-block">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Make sure your plugin %s is in the ' . APP_DIR . DS . 'Plugin directory and was loaded', $plugin); ?>
</div>
<pre>
&lt;?php
CakePlugin::load('<?php echo $plugin?>');

</pre>
<div class="alert alert-block">
	<strong><?php echo __d('cake_dev', 'Loading all plugins'); ?>: </strong>
	<?php echo __d('cake_dev', 'If you wish to load all plugins at once, use the following line in your ' . APP_DIR . DS . 'Config' . DS . 'bootstrap.php file'); ?>
</div>
<pre>
CakePlugin::loadAll();
</pre>

<?php echo $this->element('exception_stack_trace'); ?>
