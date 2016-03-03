<?php

require 'vendor/autoload.php';

$config = new SimParse\Config('php', 'configs/');

$config->addAdapter('serialize', 'SimParse\Adapters\SerializeAdapter');

echo '<pre>';
print_r($config->getAdapters());
echo '</pre>';

echo '<hr>';

