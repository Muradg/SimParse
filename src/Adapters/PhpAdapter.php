<?php

namespace SimParse\Adapters;

use SimParse\Adapters\InterfaceAdapter;

class PhpAdapter implements InterfaceAdapter {

	public function get($pathToFile) 
	{
		if (file_exists($pathToFile)) {
			$file = include $pathToFile;
			return $file;
		}
	}

	public function set($pathToFile, $key, $value) {}

}