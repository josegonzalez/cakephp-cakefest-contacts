<div class="users accordion">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width="50%">Name</th>
			<th width="35%">Email Address</th>
			<th width="15%">Vcard</th>
	</tr>
<?php
$i = 0;
foreach ($users as $user) {
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="head">
			<?php echo $user['User']['name']; ?>
			<div class="user_metadata">
				<div class="gravatar_image"><?php echo $gravatar->image($user['User']['email']); ?></div>
				<dl>
					<?php 
						foreach ($user['User'] as $key => $val) {
							if (!in_array($key,array('id','password','name','email','created','modified','username'))) {
								if ($val) {
									if ($key == 'twitter') {
										echo "<dt>{$key}:</dt><dd>".$this->Html->link('@'.$val, 'http://twitter.com/'.$val)."</dd>";	
									} else {
										echo "<dt>{$key}:</dt><dd>".$this->Text->autoLink($val)."</dd>";
									}
								}
							}
						}
					?>
				</dl>
			</div>
		</td>
		<td><?php echo $this->Text->autoLink($user['User']['email']); ?></td>
		<td>
			<?php
			echo $this->Html->link("vcf",array(
				'action' => 'view',
				$user['User']['id'],
				'ext' => 'vcf'
				));
			?>
		</td>
<?php
}
?>	
</table>
<?php
$html->scriptBlock('
	$(".accordion .head").click(function() {
		$(this).children().slideToggle("slow");
		return false;
	}).children().hide();
	', array('inline' => false));
?>
</div>
