<?php
echo $vcf->begin();
foreach ($user['User'] as $field => $value) {
	if (!in_array($field,array('id','password','created','modified'))) {
		echo $vcf->attr($field,$value);
	}
}
echo $vcf->end();
?>
