<?php
class LoginToken extends AppModel {
	var $name = 'LoginToken';
	var $displayField = 'token';
	var $belongsTo = array('User');

	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'user_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __('must contain only numbers', true),
				),
			),
			'token' => array(
				'required' => array(
					'rule' => array('notempty'),
					'message' => __('cannot be left empty', true),
				),
			),
			'duration' => array(
				'required' => array(
					'rule' => array('notempty'),
					'message' => __('cannot be left empty', true),
				),
			),
			'used' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('must be either yes or no', true),
				),
			),
		);
	}

}
