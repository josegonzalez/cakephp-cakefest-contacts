<h2>You put the lime in the coconut and just mix it all up!</h2>

<p>Login to share your contact information with others at the cakefest, and get their contact information.</p>
<?php
echo $this->Form->create('User',array('action'=>'login'));
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password'));
echo $this->Form->end('Login');
?>
<p style="font-style:italic;color:grey;">(* use the password for the hotel wifi)</p>
