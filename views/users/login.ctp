<p>Login to share your contact information with others at the CakeFest, and get their contact information.</p>
<?php
echo $this->Form->create('User',array('action'=>'login'));
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password'));
echo $this->Form->end('Login');
?>
<p style="font-style:italic;color:grey;">(* use the password for the hotel wifi)</p>
