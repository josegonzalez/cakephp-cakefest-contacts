<div id="edit" style="display:block;width:48%;float:left;">
loading...
</div>
<div id="index" style="display:block;width:48%;float:right;">
loading...
</div>
<div style="clear:both;"><!--e--></div>
<?php
echo $this->Html->script('jquery/jquery.form.js');
$html->scriptBlock('
	$("#edit").load("/profile",function() {
	$("#edit form").ajaxForm("#edit");
	});
	$("#index").load("/users");
	
	', array('inline' => false));
?>
