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
	 * Default type.
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $directory;

	/**
	 * Construct.
	 * @param string $type
	 * @param string $directory
	 */
	public function __construct($directory, $type = 'php')
	{
		$this->setDirectory($directory);
		$this->setType($type);
	}

	/**
	 * @param string $directory
	 */
	public function setDirectory($directory) 
	{
		if (!is_dir($directory)) {
			throw new Exception(sprintf('Folder "%s" is not found', $directory));
		}

		if (substr($directory, -1) != '/') {
			$directory.='/';
		}

		$this->directory = $directory;
	}

	/**
	 * @return string
	 */
	public function getDirectory() 
	{
		return $this->directory;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) 
	{
		$type = strtolower($type);
		
		if (!array_key_exists($type, $this->adapters)) {
			throw new OutOfBoundsException(sprintf('Type %s was not found in the array of adapters', $type));
		}

		$this->adapter = new $this->adapters[$type];
		$this->type = $type;
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
		$interface = 'SimParse\Adapters\AdapterInterface';

		if (!class_exists($path)) {
			throw new Exception(sprintf('Class "%s" is not found', $path));
		}

		$inherits = class_implements($path);

		if (!in_array($interface, $inherits)) {
			throw new Exception(sprintf("Class %s must implement interface %s", $path, $interface));
		}

		$this->adapters[$type] = $path;
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
	 * @return array|string
	 */
	public function get($var, $default = '') 
	{
		$query = explode('.', $var);

		if (count($query) <= 1) {
			throw new Exception(sprintf('Missing additional arguments in method %s', __METHOD__));
		}

		$filename = sprintf('%s%s.%s', $this->directory, array_shift($query), $this->type);

		if (!file_exists($filename)) {
			throw new Exception(sprintf('File %s is not found', $filename));
		}

		$result = null;
		$configurations = $this->adapter->get($filename);

		if (is_array($configurations)) {
			$result = $this->getElement($configurations, $query);
		}

		return ($result == null ? $default : $result);
	}

	/**
	 * @param  array $query
	 * @param  array $configurations
	 * @return string
	 */
	public function getElement($configurations, $query) 
	{
		foreach ($configurations as $key => $value) {
			if (in_array($key, $query)) {
				if (is_array($value)) {
					array_shift($query);

					return $this->getElement($configurations[$key], $query);
				}

				return $value;
			}
		}
	}

}