<?php

namespace Cookieflow\ThreeTaps\Reference;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Common\Collection;

class ReferenceClient extends Client
{
	public static function factory($config = array())
	{
		$default = array('base_url' => '');

		$required = array('base_url','scheme','auth_token','service');
		$config = Collection::fromConfig($config, $default, $required);

		$client = new self($config->get('base_url'), $config);
		$description = ServiceDescription::factory(__DIR__ . '/Resources/reference.json');
		$client->setDescription($description);
		$client->setDefaultOption('query', array(
			'auth_token' => $config->get('auth_token')
		));

        return $client;
	}
}