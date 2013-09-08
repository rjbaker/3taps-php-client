<?php

error_reporting(E_ALL | E_STRICT);

require __DIR__.'/../vendor/autoload.php';

if (!$_ENV['auth_token']) {
    die("Unable to read servce auth_token '{$_ENV['auth_token']}'\n");
}

// Instantiate the service builder
$service = Cookieflow\ThreeTaps\ThreeTapsService::factory(array(
	'auth_token' => $_ENV['auth_token']
));

Guzzle\Tests\GuzzleTestCase::setServiceBuilder($service);