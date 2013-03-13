<?php
/**
 * Upload care allows you to add basic API usage on your Models
 */

class UploadcareHelper extends AppHelper {

	/**
	 * Uploadcare API (placeholder)
	 *
	 * @var Uploadcare_Api
	 */
	private $api = null;

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
	 * Get File
	 *
	 * @param $file_id File ID
	 * @return Uploadcare_File
	 */
	public function file($file_id) {
		return $this->api()->getFile($file_id);
	}
}
