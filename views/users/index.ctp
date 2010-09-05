<div class="users accordion">
<?php

foreach ($users as $user) {
	echo '<div class="user">';
	echo $this->Html->div('head', "{$user['User']['name']} {$user['User']['email']}");
	echo '<div class="body">';
		debug($user);
		foreach ($user['User'] as $key => $val) {
			echo "<dl>";
			if (!in_array($key,array('id','password','name','email'))) {
				echo "<dt>{$key}</dt><dd>: {$val}</dd>";
			}
			echo "</dl>";
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
