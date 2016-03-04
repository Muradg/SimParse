# SimParse

##Example

Firstly, we need to create a folder to store configurations. Then, when we initialize the object, the first parameter is passed the directory where the files will be stored configurations. The second parameter, specify a file type. (Default php)

```php
	$config = new SimParse\Config('configs/', 'php');
```

When an object is created, we can expand the library by adding your adapters by addAdapter:

```php
	$config->addAdapter('serialize', 'SimParse\Adapters\SerializeAdapter')
```

To get the data from the file, use the function get().
For example, to retrieve data from configs/config.php file we write the following:

```php
	[
		'mysql' => [
			'host' 	=> 'default',
			'user' 	=> 'default',
			'db' 	=> 'default',
		]
	]
```

To get the value of db, the code will be as follows:

```php
	$config->get('config.mysql.db');
```

Return value from file configs/config.php => key [sqlite]
