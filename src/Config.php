<?php 

namespace SimParse;

class Config
{
	/**
	 * [$adapter]
	 * @var [object]
	 */
	protected $adapter;

	/**
	 * [$types]
	 * @var [array]
	 */
	protected $types = ['xml', 'php', 'json'];

	/**
	 * [$type default type]
	 * @var string
	 */
	private $type = 'PHP';
	
	/**
	 * [$dirname default dirname]
	 * @var string
	 */
	private $dirname = 'configs/';

	/**
	 * [__construct]
	 * @param string $type
	 * @param string $dirname
	 */
	public function __construct($type = '', $dirname = '')
	{
		$this->setType($type);
		$this->setDirectory($dirname);
	}

	/**
	 * [setDirectory]
	 * @param [string] $dirname
	 */
	public function setDirectory($dirname) 
	{
		$dirname = $_SERVER['DOCUMENT_ROOT'].'/'.$dirname;
		if (!is_dir($dirname)) {
			mkdir($dirname);
		}
		$this->dirname = $dirname;
	}

	/**
	 * [getDirectory]
	 * @return [string]
	 */
	public function getDirectory() 
	{
		return $this->dirname;
	}

	/**
	 * [setType]
	 * @param [string] $type
	 */
	public function setType($type) 
	{
		$type = strtolower($type);
		if (in_array($type, $this->types)) {

			$className = ucfirst($type).'Adapter';
			$config = new $className;

			$this->adapter = $config;
			$this->type = $type;
		}

	}

	/**
	 * [getType]
	 * @return [string]
	 */
	public function getType() 
	{
		return $this->type;
	}

	/**
	 * [getParam]
	 * @param  [string] $var
	 * @return [array]
	 */
	public function getParams($var)
	{
		$params 	= explode('.', $var);
		$key 		= array_pop($params);
		$file 		= implode('', $params).'.'.$this->type;

		$pathToFile = $this->dirname.$file;

		return $this->adapter->get($pathToFile, $key);
	}

	public function get() {}

}