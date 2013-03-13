<?php
/**
 * Loader for the Uploadcare API files
 *
 * Usage:
 * App::uses('UploadcareUtil', 'Uploadcare.Lib');
 * Uploadcare::api();
 *
 */
class UploadcareUtil {

	/**
	 * Placeholder
	 *
	 * @var boolean
	 */
	static $isSetup = false;

	/**
	 * Iniitalize and load files
	 * (not done on construct to reduce RAM usage)
	 *
	 * @return boolean
	 */
	static function setup() {
		if (UploadcareUtil::$isSetup) {
			return true;
		}
		$UploadcarePhpPath = dirname(__FILE__) . DS . 'uploadcare-php' . DS . 'uploadcare' . DS . 'lib';
		if (strnatcmp(phpversion(),'5.3') >= 0) {
			require_once $UploadcarePhpPath . DS . '5.2' . DS . 'Uploadcare.php';
		} else {
			require_once $UploadcarePhpPath . DS . '5.2' . DS . 'Uploadcare.php';
		}
		UploadcareUtil::$isSetup = true;
		return true;
	}

	/**
	 * Setup the API object/class and return it
	 *
	 * @return object Uploadcare_Api
	 */
	static function api() {
		UploadcareUtil::setup();
		Configure::load('uploadcare');
		$public_key = Configure::read('Uploadcare.public_key');
		$secret_key = Configure::read('Uploadcare.secret_key');
		if (empty($public_key) || empty($secret_key)) {
			throw new OutOfBoundsException('UploadcareBehavior::setup() error: you must configure the API keys');
		}
		if ($public_key=='demopublickey' || $secret_key=='demoprivatekey') {
			throw new OutOfBoundsException('UploadcareBehavior::setup() error: you have the "demo" keys specified');
		}
		return new Uploadcare_Api($public_key, $secret_key);
	}
}
