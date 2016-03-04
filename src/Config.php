<?php 

namespace SimParse;

use Exception;
use OutOfBoundsException;

class Config
{
	/**
	 * @var object
	 */
	protected $adapter;

	/**
	 * Array of adapters.
	 * @var array
	 */
	protected $adapters = [
		'php' 	=> 'SimParse\Adapters\PhpAdapter',
		'json' 	=> 'SimParse\Adapters\JsonAdapter',
		'xml' 	=> 'SimParse\Adapters\XmlAdapter',
	];

	/**
	 * Default interface.
	 * @var string
	 */
	protected $interface = 'SimParse\Adapters\InterfaceAdapter';

	/**
	 * Default type.
	 * @var string
	 */
	protected $type = 'php';

	/**
	 * @var string
	 */
	protected $dirname;

	/**
	 * @var array
	 */
	protected $query;

	/**
	 * @var array
	 */
	protected $configurations;

	/**
	 * Construct.
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
		if (is_dir($dirname)) {
			$this->dirname = $dirname;
		} else {
			throw new Exception(sprintf('Folder "%s" is not found', $dirname));
		}
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
			$this->adapter = new $this->adapters[$type];
			$this->type = $type;
		} else {
			throw new OutOfBoundsException(sprintf('Type %s was not found in the array of adapters', $type));
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
			} else {
				throw new Exception(sprintf("Class %s must implement interface %s", $path, $this->interface));
			}
		} else {
			throw new Exception(sprintf('Class "%s" is not found', $path));
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
	 * Return array configurations.
	 * @param  [string] $var
	 * @return array|string
	 */
	public function get($var) 
	{
		$this->query = explode('.', $var);
		if (count($this->query) <= 1) {
			throw new Exception(sprintf('Missing additional arguments in method %s', __METHOD__));
		}

		$fileName = $this->dirname . array_shift($this->query) .'.'. $this->type;

		$this->configurations = $this->adapter->get($fileName);

		return $this->getElement();
	}

	public function getElement() 
	{	
		foreach ($this->configurations as $key => $value) {
			if (in_array($key, $this->query)) {

				if (is_array($value)) {
					$this->configurations = $this->configurations[$key];
					array_shift($this->query);

					return $this->getElement();
				}

				return $value;
			}
		}
	}

}