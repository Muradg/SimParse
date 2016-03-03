<?php

namespace SimParse\Adapters;

interface InterfaceAdapter {
	public function get($pathToFile, $key);
	public function set($pathToFile, $key, $value);
}