<?php
/**
 * ExpandableBehavior
 *
 * @package default
 * @access public
 */
class ExpandableBehavior extends ModelBehavior{
	var $settings = array();

	function setup(&$model, $settings = array()) {
		$base = array('schema' => $model->schema());
		if (isset($settings['with'])) {
			$conventions = array('foreignKey' => $model->hasMany[$settings['with']]['foreignKey']);
			return $this->settings[$model->alias] = am($base, $conventions, $settings);
		}
		$commonHasMany = array(
			"MetaField" => array(
				'className' => 'MetaField',
				'foreignKey' => 'model_id',
				'conditions' => array('MetaField.model' => $model->alias),
				'dependent' => true,
				'exclusive' => true
			)
		);
		$model->bindModel(array('hasMany' => $commonHasMany), false);
		$commonBelongsTo = array(
			$model->alias => array(
				'className' => $model->alias,
				'foreignKey' => 'model_id',
			)
		);
		$model->MetaField->bindModel(array('belongsTo' => $commonBelongsTo), false);
		foreach ($model->hasMany as $assoc => $option) {
			if (strpos($assoc, 'Field') !== false) {
				$conventions = array('with' => $assoc, 'foreignKey' => $model->hasMany[$assoc]['foreignKey']);
				return $this->settings[$model->alias] = am($base, $conventions, !empty($settings) ? $settings : array());
			}
		}
	}

	function afterFind(&$model, $results, $primary) {
		extract($this->settings[$model->alias]);
		if (!Set::matches("/{$with}", $results)) {
			return;
		}
		foreach ($results as $i => $item) {
			foreach ($item[$with] as $field) {
				$results[$i][$model->alias][$field['key']] = $field['value'];
			}
		}
		return $results;
	}

	function afterSave(&$model) {
		extract($this->settings[$model->alias]);
		$fields = array_diff_key($model->data[$model->alias], $schema);
		$id = $model->id;
		foreach ($fields as $key => $val) {
			if ($key == 'tags') {
				continue;
			}
			$field = $model->{$with}->find('first', array(
				'fields' => array("{$with}.id"),
				'conditions' => array("{$with}.{$foreignKey}" => $id, "{$with}.key" => $key),
				'recursive' => -1,
			));
			$model->{$with}->create(false);
			if ($field) {
				$model->{$with}->set('id', $field[$with]['id']);
			} else {
				$model->{$with}->set(array($foreignKey => $id, 'key' => $key));
			}
			if (is_array($val)){
				$date = null;
				$time = null;
				if ($this->array_keys_exist(array('month', 'day', 'year'), $val)) {
					$date = "{$val['year']}-{$val['month']}-{$val['day']}";
				}
				if ($this->array_keys_exist(array('hour', 'min'), $val)) {
					if (array_key_exists('meridian', $val)) {
						if ($val['hour'] != 12 && 'pm' == $val['meridian']) {
							$val['hour'] = $val['hour'] + 12;
						} else if ($val['hour'] == 12 && 'am' == $val['meridian']) {
							$val['hour'] = '00';
						}
					}
					$time = "{$val['hour']}:{$val['min']}:00";
				}
				$val = ($date) ? (($time) ? "{$date} {$time}" : $date) : (($time) ? $time : null);
			}
			$model->{$with}->set('value', $val);
			$model->{$with}->set('model', $model->alias);
			$model->{$with}->save();
		}
	}

	function array_keys_exist($keys, $array) {
		foreach($keys as &$k) {
			if(!isset($array[$k])) {
				return false;
			}
		}
		return true;
	}
}
?>