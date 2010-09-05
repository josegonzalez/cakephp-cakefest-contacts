<?php 
/* SVN FILE: $Id$ */
/* Contacts schema generated on: 2010-09-05 00:09:40 : 1283665720*/
class ContactsSchema extends CakeSchema {
	var $name = 'Contacts';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $meta_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);
	var $users = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
}
?>