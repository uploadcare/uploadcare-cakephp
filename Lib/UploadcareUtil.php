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
	 * @var mixed object or null
	 */
	static $api = null;

	/**
	 * Setup the API object/class and return it
	 *
	 * @return object Uploadcare_Api
	 */
	static function api() {
		if (!empty(UploadcareUtil::$api)) {
		return UploadcareUtil::$api;
		}
		// verify config
		Configure::load('uploadcare');
		$public_key = Configure::read('Uploadcare.public_key');
		$secret_key = Configure::read('Uploadcare.secret_key');
		if (empty($secret_key)) {
			$secret_key = Configure::read('Uploadcare.private_key'); // alt naming, deprecated
		}
		if (empty($public_key) || empty($secret_key)) {
			throw new OutOfBoundsException('UploadcareUtil::api() error: you must configure the API keys');
		}
		if ($public_key=='demopublickey' || $secret_key=='demoprivatekey') {
			throw new OutOfBoundsException('UploadcareUtil::api() error: you have the "demo" keys specified');
		}
		// load in vendors and initialize api
		$UploadcarePhpPath = dirname(__FILE__) . DS . 'uploadcare-php' . DS . 'uploadcare' . DS . 'lib';
		if (strnatcmp(phpversion(),'5.3') >= 0) {
			require_once $UploadcarePhpPath . DS . '5.3-5.4' . DS . 'Uploadcare.php';
			UploadcareUtil::$api = new Uploadcare\Api($public_key, $secret_key);
		} else {
			require_once $UploadcarePhpPath . DS . '5.2' . DS . 'Uploadcare.php';
			UploadcareUtil::$api = new Uploadcare_Api($public_key, $secret_key);
		}
		return UploadcareUtil::$api;
	}
}
