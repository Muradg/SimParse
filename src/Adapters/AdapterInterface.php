<?php

namespace SimParse\Adapters;

interface AdapterInterface {
	public function get($path);
	public function set($path, $key, $value);
}