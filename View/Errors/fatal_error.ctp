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
 * @since         CakePHP(tm) v 2.2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="alert alert-error">
<h4><?php echo __d('cake_dev', 'Fatal Error'); ?></h4>
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo h($error->getMessage()); ?>
	<br>

	<strong><?php echo __d('cake_dev', 'File'); ?>: </strong>
	<?php echo h($error->getFile()); ?>
	<br>

	<strong><?php echo __d('cake_dev', 'Line'); ?>: </strong>
	<?php echo h($error->getLine()); ?>
</div>
