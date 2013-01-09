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
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="alert alert-error">
<h4><?php echo __d('cake_dev', 'Database Error'); ?></h4>
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo h($error->getMessage()); ?>
</div>
<?php if (!empty($error->queryString)) : ?>
	<div class="alert alert-block">
		<strong><?php echo __d('cake_dev', 'SQL Query'); ?>: </strong>
		<?php echo  $error->queryString; ?>
	</div>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
		<strong><?php echo __d('cake_dev', 'SQL Query Params'); ?>: </strong>
		<?php echo  Debugger::dump($error->params); ?>
<?php endif; ?>

<?php echo $this->element('exception_stack_trace'); ?>
