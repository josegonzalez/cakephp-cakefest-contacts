<div class="meta">
<?php
$this->SelfFieldCounter = (isset($this->SelfFieldCounter) ? $this->SelfFieldCounter++ : 0);
echo $this->Form->input("MetaField.{$this->SelfFieldCounter}.field",array(
	'div' => false,
	'label' => false,
	'value' => (isset($field) ? $field : ''),
	));
echo $this->Form->input("MetaField.{$this->SelfFieldCounter}.value",array(
	'div' => false,
	'label' => false,
	'value' => (isset($value) ? $value : ''),
	));
?>
</div>
