<?php

namespace SimParse\Adapters;

interface AdapterInterface {
	public function get($pathToFile);
	public function set($pathToFile, $key, $value);
}