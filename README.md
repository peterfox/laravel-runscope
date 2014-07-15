Runscope for PHP
================

- Requires a free Runscope account, [sign up here](https://www.runscope.com/signup)
- Makes it easy to generate Runescope urls
- Provides plugins for both [Guzzle](http://guzzlephp.org) (3.0) and [GuzzleHttp](http://guzzlephp.org) (4.0)
- Has dependancy injection support for Laravel 4, through included ServiceProvider and Facade classes

Install by issuing:

```cli
composer require peterfox/runscope
```

The most basic usage is as follows:

```php
<?php
require __DIR__ . '/../vendor/autoload.php';

use Runscope\Runscope;

$runscope = new Runscope('api-key-here');

$runscopeUrl = $runscope->proxify('https://api.github.com');
```

Please note, generating these urls will always provide a url that works on port 80/443 for http/https respectively as using ports other than the standard ones for a protocol requires headers.

Using with Guzzle/GuzzleHttp
----------------------------

applying the plugin is like so for Guzzle:

```php
<?php
require __DIR__ . '/../vendor/autoload.php';

use Runscope\Runscope;
use Guzzle\Http\Client;
use Runscope\Plugin\Guzzle\RunscopePlugin;

$runscope = new Runscope('api-key-here');

$client = new Client('https://api.github.com');

$runscopePlugin = new RunscopePlugin($runscope);

// Add the plugin
$client->addSubscriber($runscopePlugin);

// Send the request and get the response
$response = $client->get('/')->send();
```

Using the GuzzleHttp Plugin can be done with:

```php
<?php
require __DIR__ . '/../vendor/autoload.php';

use Runscope\Runscope;
use GuzzleHttp\Client;
use Runscope\Plugin\GuzzleHttp\RunscopePlugin;

$runscope = new Runscope('api-key-here');

$client = new Client('https://api.github.com');

$runscopePlugin = new RunscopePlugin($runscope);

// Attach the plugin
$client->getEmitter()->attach($runscopePlugin);

// Send the request and get the response
$response = $client->get('/');
```

Laravel 4 Integration
---------------------

Add the service provider:

```php
'providers' => array(
    ...
    'Runscope\RunscopeServiceProvider'
)
```

You can then publish the config file from the package:

```cli
php artisan config:publish peterfox/runscope
```

The blank config will at a minimum require your bucket key (ID):

```php
<?php

return array(
    'bucket_key' => '',
    'auth_token' => null,
    'gateway_host' => 'runscope.net'
);

```


With the service provider in place it will also set up the Facade for you so you can use:

```php
$url = Runscope::proxify('https://api.github.com');
```

You'll also have a helper function which makes things a little lighter

```php
$url = runscope_url('https://api.github.com');
```
