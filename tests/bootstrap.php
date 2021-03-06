<?php

error_reporting(E_ALL | E_STRICT);

require __DIR__.'/../vendor/autoload.php';

if (!$_ENV['auth_token']) {
    die("Unable to read servce auth_token '{$_ENV['auth_token']}'\n");
}

$token = getenv('CI_AUTH_TOKEN') ? getenv('CI_AUTH_TOKEN') : getenv('auth_token');

// Instantiate the service builder
$service = Rbaker\ThreeTaps\ThreeTapsService::factory(array(
	'auth_token' => $token
));

Guzzle\Tests\GuzzleTestCase::setServiceBuilder($service);