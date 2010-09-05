<?php
/* LoginToken Test cases generated on: 2010-09-05 02:09:38 : 1283668838*/
App::import('Model', 'LoginToken');

class LoginTokenTestCase extends CakeTestCase {
	var $fixtures = array('app.login_token');

	function startTest() {
		$this->LoginToken =& ClassRegistry::init('LoginToken');
	}

	function endTest() {
		unset($this->LoginToken);
		ClassRegistry::flush();
	}

}
?>