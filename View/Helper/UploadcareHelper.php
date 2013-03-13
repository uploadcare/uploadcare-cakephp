<?php
require_once dirname(__FILE__).'/../../uploadcare-php/uploadcare/lib/5.2/Uploadcare.php';

class UploadcareHelper extends AppHelper
{
	/**
	 * Uploadcare API
	 * 
	 * @var Uploadcare_Api
	 **/
	private $api = null;
	
	/**
	 *
	 **/
	public function __construct($View, $settings)
	{
		$config = Configure::read('uploadcare');
		$public_key = $config['public_key'];
		$secret_key = $config['private_key'];
		$this->api = new Uploadcare_Api($public_key, $secret_key);		
		parent::__construct($View, $settings);
	}
	
	/**
	 * Get API instance
	 *
	 * @return Uploadcare_Api
	 **/
	public function api()
	{
		return $this->api;
	}	
	
	/**
	 * Get File
	 * 
	 * @param $file_id File ID
	 * @return Uploadcare_File
	 **/
	public function file($file_id)
	{
		return $this->api->getFile($file_id);
	}
}