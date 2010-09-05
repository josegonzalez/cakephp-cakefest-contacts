<div id="edit" style="display:block;width:48%;float:left;">
loading...
</div>
<div id="index" style="display:block;width:48%;float:right;">
loading...
</div>
<div style="clear:both;"><!--e--></div>
<?php
$html->scriptBlock('
	$("#edit").load("/profile");
	$("#index").load("/users");
	', array('inline' => false));
?>
