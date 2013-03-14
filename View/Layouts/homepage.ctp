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
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$url = $this->request->here;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Infinite Rooms: Learner Enhanced Technology</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
	<?php
		//echo $this->Html->meta('icon');

        echo $this->Html->css('normalize');
        echo $this->Html->css('main');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('jquery-ui');
        echo $this->Html->css('infiniterooms');

        echo $this->Html->script('modernizr');
        echo $this->Html->script('jquery');
        echo $this->Html->script('jquery-ui');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('activity-stream');
        echo $this->Html->script('googleAnalytics');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link('Infinite Rooms', array('controller' => 'pages', 'action' => 'display', 'home')); ?></h1>
			<p id="tagline">Learner Enhanced Technology</p>
		</div>
		<div id="menu">
      <ul class="nav nav-pills">
        <li class="first<?php echo (preg_match("/Stats/", $url))? ' active' : ''?>"><?php echo $this->Html->link('Overall Statistics', '/Stats'); ?></li>
        <li<?php echo (preg_match("/CourseProfile/", $url))? ' class="active"' : ''?>><?php echo $this->Html->link('Course Profile', '/CourseProfile'); ?></li>
        <li<?php echo (preg_match("/UserProfile/", $url))? ' class="active"' : ''?>><?php echo $this->Html->link('User Profile', '/UserProfile'); ?></li>
      </ul>
    </div>
		<div class="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
