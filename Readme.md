# goo.gl URL shortener API

## Install
```bash
$ composer require dominikveils/goo-gl
```

## Usage
```php
<?php

require 'vendor/autoload.php';

$googl = new DominikVeils\Googl\Googl('API KEY');

$short_url =  $googl->shorten('http://google.com');
echo "SHORT URL: {$short_url}", PHP_EOL;
$long_url = $googl->expand($short_url);
echo "LONG URL: {$long_url}", PHP_EOL;
```

## LICENSE
MIT