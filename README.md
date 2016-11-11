# PbxManager plugin for CakePHP

## Installation

1. Clone [Repository] into ```plugins/``` folder 

	```bash
	clone https://github.com/charluemm/pbx-recording.git
	```
2. enable ```PbxManager``` plugin

	```php
	// config/bootstrap.php
	Plugin::load('PbxManager', ['bootstrap' => false, 'routes' => true, 'autoload' => true]);
	```
3. Create new config-file to override default config.


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
        "wsdl" => null,
        "server" => null,
        "login" => null,
        "password" => null
    )
    );
	```

[Repository]: https://github.com/charluemm/pbx-recording.git
