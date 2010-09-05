<?php 
header("Content-disposition: attachment; filename=$filename.vcf");
header("Content-type: text/text/x-vcard"); 
echo $content_for_layout; 
?>
