<?php

namespace SimParse\Adapters;

interface InterfaceAdapter {
	public function get($pathToFile);
	public function set($pathToFile, $key, $value);
}