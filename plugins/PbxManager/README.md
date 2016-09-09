# PbxManager plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require your-name-here/PbxManager
```

## create SOAP Configuration

Create new config-file to override default config.


```php
// config/soap_config.php
<?php
$config = array(
	"proxy" => array(
        "host" => null,
        "port" => null,
		"login" => null,
		"password" => null
    ),
	"soap" => array(
		"url" => null,
		"login" => null,
		"password" => null
	)
);
```