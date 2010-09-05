<h3>Login / Register to share your info with other CakeFest attendees!</h3>
<?php
echo $this->Form->create('User',array('action'=>'login'));
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password', 'after' => 'Hint: What was the James hotel wifi password?'));
echo $this->Form->end('Login');
?>
