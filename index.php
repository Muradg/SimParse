<?php

require 'vendor/autoload.php';

$config = new SimParse\Config('configs');

echo $config->get('config.test');
