<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'reset',
			'layout',
			'elements',
			'/js/jquery/prettyPhoto/css/prettyPhoto.minimal',
		));
		echo $this->Html->script(array(
			'jquery/jquery-1.4.2.min',
			'jquery/jquery-ui-1.8.4.custom.min',
			//'jquery/jquery.color',
			//'jquery/animateClass.compressed',
			'general',
		));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php echo $this->element('layout/header')?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->element('layout/footer')?>
		</div>		
	</div>
	<?php 
	echo $this->Js->writeBuffer(); 
	echo $scripts_for_layout;
	?>
</body>
</html>