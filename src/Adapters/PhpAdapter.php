<?php

namespace SimParse\Adapters;

use SimParse\Adapters\TemplateAdapter;

class PhpAdapter implements TemplateAdapter {

	public function get($pathToFile, $key) 
	{
		if (file_exists($pathToFile)) {
			$file = include $pathToFile;
			return $file[$key];
		}
	}

	public function set($pathToFile, $key, $value) {}

}