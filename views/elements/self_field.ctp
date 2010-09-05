<div class="meta">
	<?php $this->SelfFieldCounter = (isset($this->SelfFieldCounter) ? $this->SelfFieldCounter+1 : 0);?>
	<label>
		<?php echo $this->Form->input("MetaField.{$this->SelfFieldCounter}.field",array(
			'div' => false,
			'label' => false,
			'type' => 'text',
			'value' => (isset($field) ? $field : ''),
		));?>
	</label>
	<?php echo $this->Form->input("MetaField.{$this->SelfFieldCounter}.value",array(
		'div' => false,
		'label' => false,
		'type' => 'text',
		'value' => (isset($value) ? $value : ''),
	)); ?>
</div>
