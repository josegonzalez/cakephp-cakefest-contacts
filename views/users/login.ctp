<p>Login to share your contact information with others at the cakefest, and get their contact information.</p>
<?php
echo $this->Form->create('User',array('action'=>'login'));
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password'));
echo $this->Form->end('Login');
?>
<p style="font-style:italic;color:grey;">(* us the password at the hotel)</p>
