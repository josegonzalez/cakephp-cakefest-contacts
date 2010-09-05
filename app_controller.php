<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array(
		'Goodies.Gravatar',
		'Session',
		'Text',
		'Js' => array('Jquery'),
		'Vcard.Vcf'
	);

	var $components = array(
		'Authsome.Authsome' => array(
			'model' => 'User'
		),
		'DebugKit.Toolbar',
		'Session',
		'RequestHandler',
	);
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->helpers[] = 'vcf';
		$this->RequestHandler->setContent('vcf', 'text/x-vcard');
	}
	
	function beforeRender() {
		$titles = array(
			'Too Drunk, lost your number',
			'You\'ve Reached the rejection hotline...',
			'Two Beers Left',
			'You\'re not using your boobs correctly',
			'Put de lime in de coconut, and drink \'em both up',
			'You\'re code SUCKS!',
			'Shifting paradigms...',
			'There\'s one beer left!',
			'It\'s really hard when your input is only an inch big',
			'It\'s an MVC tree in an MVC tree',
			'Balls deep in HTTP sockets',
			'I couldn\'t find a decent picture of fat models so...',
			'Oh it\'s in my crotch',
			'What happens at CakeFest... STAYS at CakeFest',
			'Angry Jose and Nice Jose',
			'Unless it\'s a video of Gabriel dancing...',
			'C.P.S.R.',
		);
		$this->set('title_for_layout', $titles[rand(0, count($titles)-1)]);
	}
}
