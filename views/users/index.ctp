<?php
foreach ($users as $user):
?>
<div class="user-data">
<span>
<?php
	echo "{$user['User']['username']} {$user['User']['email']}";
?>
</span><span>
<?php
	echo $this->Html->link("vcs",array(
		'action' => 'vcs',
		$user['User']['id']
		));
?>
</span><span>
<?php
	echo $this->Html->link("edit",array(
		'action' => 'edit',
		$user['User']['id']
		));
?>
</span>
<div class="user-data-sub">
	<?php debug($this->data['User']); ?>
</div>
</div>
<?php
endforeach;
?>
<p style="font-style:italic;color:grey;">(* use the password for the hotel wifi)</p>
