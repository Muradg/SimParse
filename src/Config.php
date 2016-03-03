<?php 

namespace SimParse;

class Config
{
	/**
	 * @var object
	 */
	protected $adapter;

	/**
	 * array of adapters
	 * @var array
	 */
	protected $adapters = [
		'php' 	=> 'SimParse\Adapters\PhpAdapter',
		'json' 	=> 'SimParse\Adapters\JsonAdapter',
		'xml' 	=> 'SimParse\Adapters\XmlAdapter',
	];

	/**
	 * default interface
	 * @var string
	 */
	protected $interface = 'SimParse\Adapters\InterfaceAdapter';

	/**
	 * default type
	 * @var string
	 */
	protected $type = 'php';

	/**
	 * @var string
	 */
	protected $dirname;

	/**
	 * __construct
	 * @param string $type
	 * @param string $dirname
	 */
	public function __construct($type, $dirname)
	{
		$this->setType($type);
		$this->setDirectory($dirname);
	}

	/**
	 * @param string $dirname
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
	 * @return string
	 */
	public function getDirectory() 
	{
		return $this->dirname;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) 
	{
		$type = strtolower($type);
		if (array_key_exists($type, $this->adapters)) {

			$config = new $this->adapters[$type];

			$this->adapter = $config;
			$this->type = $type;
		}
	}

	/**
	 * @return string
	 */
	public function getType() 
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @param string $path
	 */
	public function addAdapter($type, $path) 
	{
		if (class_exists($path)) {
			$interfaces = class_implements($path);
			if (in_array($this->interface, $interfaces)) {
				$this->adapters[$type] = $path;
			}
		}
	}

	/**
	 * @return array
	 */
	public function getAdapters() 
	{
		return $this->adapters;
	}

	/**
	 * return array configurations
	 * @param  [string] $var
	 * @return array|string
	 */
	public function get($var) 
	{
		$params = explode('.', $var);
		$key = array_pop($params);
		$file = implode('', $params).'.'.$this->type;

		$pathToFile = $this->dirname.$file;

		return $this->adapter->get($pathToFile, $key);
	}

}