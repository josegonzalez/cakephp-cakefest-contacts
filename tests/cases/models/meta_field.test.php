<?php
/* MetaField Test cases generated on: 2010-09-05 00:09:04 : 1283665624*/
App::import('Model', 'MetaField');

class MetaFieldTestCase extends CakeTestCase {
	var $fixtures = array('app.meta_field');

	function startTest() {
		$this->MetaField =& ClassRegistry::init('MetaField');
	}

	function endTest() {
		unset($this->MetaField);
		ClassRegistry::flush();
	}

}
?>