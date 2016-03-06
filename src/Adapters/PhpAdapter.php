<?php

namespace SimParse\Adapters;

use SimParse\Adapters\AdapterInterface;

class PhpAdapter implements AdapterInterface {

	public function get($path) 
	{
		$params = require $path;

		return $params;
	}

	public function set($path, $key, $value) {}

}