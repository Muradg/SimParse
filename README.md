# SimParse

##Example

First we need to create a folder to store configurations. Then, when the object is initialized, the first parameter to specify specify the file type and the second - a directory, where the configs are stored.

```php
	$config = new SimParse\Config('php', 'configs/');
```

Then you can get the configuration file through your point. The first parameter specifies the name of the file, and the following parameters indicate the keys in an array of configurations

```php
	echo $config->get('config.sqlite');
```

Return value from file configs/config.php => key [sqlite]
