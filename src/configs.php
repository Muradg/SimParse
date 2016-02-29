<?php 

/**
* 
*/
class Config
{
	public $params = [];
	public $adapter = '';

	private $type = 'PHP';
	private $dirname = 'configs/';
	private static $types = ['xml', 'php', 'json'];

	public function __construct($type = '', $dirname = '')
	{
		$this->setType($type);
		$this->setDirectory($dirname);
	}

	public function setDirectory($dirname) 
	{
		$dirname = $_SERVER['DOCUMENT_ROOT'].'/'.$dirname;
		if (!is_dir($dirname)) {
			mkdir($dirname);
		}
		$this->dirname = $dirname;
	}

	public function getDirectory() 
	{
		return $this->dirname;
	}

	public function setType($type) 
	{
		$type = strtolower($type);
		if (in_array($type, self::$types)) {

			$className = ucfirst($type).'Adapter';
			$config = new $className();

			$this->adapter = $config;
			$this->type = $type;
			
			return true;
		}

		return false;
	}

	public function getType() 
	{
		return $this->type;
	}

	public function getParam($var) {
		$params 	= explode('.', $var);
		$key 		= array_pop($params);
		$file 		= implode('', $params).'.'.$this->type;

		$pathToFile = $this->dirname.$file;

		return $this->adapter->get($pathToFile, $key);
	}

}