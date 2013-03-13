<?php
/**
 * Upload care allows you to add basic API usage on your Models
 */

class UploadcareBehavior extends ModelBehavior {

	/**
	 * List of fields to act as file_id
	 *
	 * @var array
	 */
	private $fields = array();

	/**
	 * Uploadcare API
	 *
	 * @var Uploadcare_Api
	 */
	private $api = null;

	/**
	 * Model Setup / initalization function
	 *
	 * @param Model $model
	 * @param array $fields
	 * @return boolean
	 */
	public function setup(Model $model, $fields = array()) {
		$this->fields = $fields;
		return true;
	}

	/**
	 * Get API instance
	 * only runs once, so if it already is setup, it doesn't waste cycles
	 *
	 * @return Uploadcare_Api
	 */
	public function api() {
		if (!empty($this->api)) {
			return $this->api;
		}
		App::uses('UploadcareUtil', 'Uploadcare.Lib');
		$this->api = Uploadcare::api();
		return $this->api;
	}

	/**
	 * After save callback for model
	 *
	 * @param Model $model
	 * @param boolean $created True if this save created a new record
	 * @return boolean
	 */
	public function afterSave(Model $model, $created = null) {
		foreach ($this->fields as $field) {
			if (isset($model->data[$model->alias][$field])) {
				$file_id = $model->data[$model->alias][$field];
				$file = $this->api()->getFile($file_id);
				$file->store();
			}
		}
		return true;
	}
}
