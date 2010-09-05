<div class="users accordion">
<?php

foreach ($users as $user) {
	echo '<div class="user">';
	echo $this->Html->div('head', "{$user['User']['name']} {$user['User']['email']}");
	echo '<div class="body">';
		foreach ($user['User'] as $key => $val) {
			if (!in_array($key,array('id','password','name','email'))) {
				echo $this->Html->div('', "{$key}: {$val}");
			}
		}
		echo $this->Html->link("vcs",array(
			'action' => 'vcs',
			$user['User']['id']
			));
	echo '</div>';
}
$html->scriptBlock('
	$(".accordion .head").click(function() {
		$(this).next().toggle("slow");
		return false;
	}).next().hide();
	', array('inline' => false));
?>
</div>
