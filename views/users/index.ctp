<?php

foreach ($users as $user) {
	
	echo "{$user['User']['username']} {$user['User']['email']}";
	echo $this->Html->link("vcs",array(
		'action' => 'vcs',
		$user['User']['id']
		));
	echo $this->Html->link("edit",array(
		'action' => 'edit',
		$user['User']['id']
		));
}

?>
<p style="font-style:italic;color:grey;">(* use the password for the hotel wifi)</p>
