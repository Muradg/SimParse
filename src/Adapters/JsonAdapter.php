<?php

namespace SimParse\Adapters;

use SimParse\Adapters\AdapterInterface;

class JsonAdapter implements AdapterInterface {

	public function get($path) {
			$params = json_decode(file_get_contents($path), true);

			return $params;
	}

	public function set($path, $key, $value) {}

}