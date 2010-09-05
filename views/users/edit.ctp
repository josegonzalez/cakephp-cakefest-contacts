<p>Login to share your contact information with others at the cakefest, and get their contact information.</p>
<?php
echo $this->Form->create('User',array('action'=>'edit'));
echo $this->Form->hidden('id');
echo $this->Form->input('email');
echo $this->Form->input('password',array('type'=>'password'));
echo $this->Form->input('password_confirm',array('type'=>'password'));
foreach (array_diff_key((array)$this->data['User'],array(
	'id' => 0, 'email' => 0, 'password' => 0, 'username' => 0,
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
			if ($(this).parent().find("input:first").val()=="" && 
				$(this).parent().prev().find("input:first").val()=="") {
				$(this).parent().hide();
			} else {
				$(this).parent().show();
				$(this).parent().next().find("input:first").trigger("change");
			}
		});
		$(div).find("input:first").trigger("change");
	});
	', array('inline' => false));
echo $this->Form->end('Save');
debug($this->data);
?>
