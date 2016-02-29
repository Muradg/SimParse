<?php

namespace SimParse\Adapters;

interface TemplateAdapter {
	public function get($pathToFile, $key);
	public function set($pathToFile, $key, $value);
}