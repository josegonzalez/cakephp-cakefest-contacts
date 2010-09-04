<p>Login to share your contact information with others at the cakefest, and get their contact information.</p>
<?php
echo $this->Form->create('User',array('action'=>'login'));
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password'));
echo $this->Form->input('password_confirm',array('type'=>'password'));

foreach (array_diff_key($this->data['User'],array(
	'id', 'email', 'password',
	)) + array(
	'phone' => '', 'skype' => '', 
	) as $field => $value) {
	echo $this->element('self_field',array(
		'field' => $field,
		'value' => $value,
		));
}
for ($i=0;$i<30;$i++) {
	echo $this->element('self_field',array());
}
$html->scriptBlock('
	$("div.meta").each(function(i,div) {
		$(div).find("input").bind("change",function(e) {
			if ($(this).parents("div").find("input:first").val()=="") {
				$(this).parents("div").hide();
			} else {
				$(this).parents("div").hide();
			}
		});
		$(div).find("input:first").trigger("change");
	});
	', array('inline' => false));

echo $this->Form->end('Save');
?>
