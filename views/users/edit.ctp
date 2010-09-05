<h3>Login to share your contact information with others at the cakefest, and get their contact information.</h3>
<?php
echo $this->Form->create('User',array('action'=>'edit'));
echo $this->Form->hidden('id');
echo $this->Form->input('name');
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password', 'after' => 'Feel free to change to a private password'));
echo $this->Form->input('password_confirm',array('type'=>'password', 'after' => 'Just don\'t use one of your actual passwords'));
foreach (array_diff_key((array)$this->data['User'],array(
	'id' => 0, 'email' => 0, 'password' => 0, 'username' => 0,
	)) + array(
	'phone' => '', 'twitter' => '', 'aim' => '',  'yim' => '',  'gtalk' => '', 'skype' => '',
	) as $field => $value) {
	if (!in_array($field,array('created','modified'))) {
		echo $this->element('self_field',array(
			'field' => $field,
			'value' => $value,
			));
	}
}
for ($i=0;$i<30;$i++) {
	echo $this->element('self_field',array());
}
echo $this->Form->end('Save');
?>
