# CakePHP Application PBX-Recording

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update

	```bash
	composer self-update
	```
2. Clone Repository

	```bash
	git clone https://github.com/charluemm/pbx-recording.git
	```
3. Run `php composer.phar install`.

If Composer is installed globally, run

	```bash
	composer install
	```

### enable PbxManager plugin

1. Clone [Repository] into ```plugins/``` folder (or copy ```plugins/PbXManager``` folder)
2. enable ```PbxManager``` plugin

	```php
	// config/bootstrap.php
	Plugin::load('PbxManager', ['bootstrap' => false, 'routes' => true, 'autoload' => true]);
	```

[Repository]: https://github.com/charluemm/pbx-recording.git