<?php

namespace SimParse\Adapters;

use SimParse\Adapters\AdapterInterface;

class PhpAdapter implements AdapterInterface {

	public function get($pathToFile) 
	{
		if (file_exists($pathToFile)) {
			$file = include $pathToFile;
			
			return $file;
		}
	}

	public function set($pathToFile, $key, $value) {}

}