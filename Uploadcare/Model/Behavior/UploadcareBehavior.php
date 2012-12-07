<?php

require_once dirname(__FILE__).'/../../uploadcare-php/uploadcare/lib/5.2/Uploadcare.php';

class UploadcareBehavior extends ModelBehavior
{
	/**
	 * List of fields to act as file_id
	 * 
	 * @var array
	 **/
	private $fields = array();
	
	/**
	 * Uploadcare API
	 * 
	 * @var Uploadcare_Api
	 **/
	private $api = null;
	
	
	public function setup(Model $model, $fields = array())
	{
		$public_key = Configure::read('uploadcare_public_key');
		$secret_key = Configure::read('uploadcare_secret_key');
		$this->api = new Uploadcare_Api($public_key, $secret_key);		
		$this->fields = $fields;
	}		
	
	public function afterSave(Model $model, $created = array())
	{
		foreach ($this->fields as $field) {
			if (isset($model->data[$model->alias][$field])) {
				$file_id = $model->data[$model->alias][$field];
				$file = $this->api->getFile($file_id);
				$file->store();				
			}
		}
	}
}