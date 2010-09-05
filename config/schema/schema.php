<?php 
/* SVN FILE: $Id$ */
/* CakefestContacts schema generated on: 2010-09-05 02:09:20 : 1283669480*/
class CakefestContactsSchema extends CakeSchema {
	var $name = 'CakefestContacts';

	var $file = 'schema_6.php';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $login_tokens = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'key' => 'index'),
		'duration' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32),
		'used' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'expires' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'token' => array('column' => 'token', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $meta_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);
	var $users = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
}
?>