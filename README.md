3taps-php-client
================

A PHP 5.3+ client for working with the [3taps](https://3taps.com) APIs.
[![Build Status](https://travis-ci.org/cookieflow/3taps-php-client.png?branch=master)](https://travis-ci.org/cookieflow/3taps-php-client)

## Features

* Built on top of the awesome [Guzzle](http://guzzlephp.org) HTTP client framework.
* Provides separate clients for the Reference, Search and Polling APIs.
* Result iterators to automatically handle result pagination, tokens, tiers and anchors.
* Include in your project using [Composer](https://packagist.org/packages/cookieflow/3taps-client) or download the [zip](https://github.com/cookieflow/3taps-php-client/archive/master.zip).
* Tested with PHP 5.3, 5.4 & 5.5.

## Usage

### Install using Composer
```
composer.phar require cookieflow/3taps-client
```

### Create a service instance

```php
use Cookieflow\ThreeTaps\ThreeTapsService;

$service = ThreeTapsService::factory(array(
	'auth_token' => 'your-private-auth-token'
));
```
### Create an API client instance (e.g. reference api)
```php
$referenceClient = $service->get('reference');
```

### Initiate an API request

```php
$categories = $referenceClient->getCategories();
```

## API Service Clients

All methods and parameters from each of the three APIs (as defined in the [3taps API docs](http://docs.3taps.com/)) are supported.

To use an API client, as in the example above, you must instantiate a relevant client instance from the service instance. API methods may then be called on the client instance.

If desired, an array of parameters may be passed into the second argument of an API method call. The PHP client will ensure all **required** parameters are provided, but be sure to consult the API documentation for all optional params.

### Reference
The Reference API client supports the following methods:

3Taps Method Name | PHP Client Method Name
--- | ---
sources | `$referenceClient->getSources()`
category_groups | `$referenceClient->getCategoryGroups()`
categories | `$referenceClient->getCategories()`
locations | `$referenceClient->getLocations()`
location lookups | `$referenceClient->locationLookup()`

#### Example:
```php
$referenceClient = $service->get('reference');
$data = $referenceClient->locationLookup(array(
	'code'=>'USA-AL'
));
```
### Search
The Search API client supports the follwing methods:

3Taps Method Name | PHP Client Method Name
--- | ---
search | `$searchClient->search()`
count mode | `$searchClient->count()`

#### Example:
```php
$searchClient = $service->get('search');
$iterator = $searchClient->getIterator('search', array(
	'category_group' => 'JJJJ'
));
$iterator->setLimit(30);
// Total number of (unlimited) results matching our request
echo $iterator->getNumMatches();
// grab results
print_r($iterator->toArray());
```
### Polling
The Polling API client supports the follwing methods:

3Taps Method Name | PHP Client Method Name
--- | ---
anchor | `$pollingClient->getAnchor()`
poll | `$pollingClient->poll()`

Please see the complete example below.

### Result Iterators
Result iterators automatically implement much of the logic required for working with pages of results. In the case of the 3taps Search and Polling APIs, the **page**, **anchor** and **tier** parameters are taken care of and automatically parameterized for subsequent requests. This allows you to simply set the number of results you need, and the iterator will attempt (if required) to make as many API calls as needed return your result set.

## A complete example
Retrieve an anchor from the polling API and poll for all job-related postings in NYC, placed in the last 3 hours.

```php
<?php

require 'vendor/autoload.php';

use Cookieflow\ThreeTaps\ThreeTapsService;

// create service instance
$service = ThreeTapsService::factory(array(
	'auth_token' => 'your-private-auth-token'
));
$pollingClient = $service->get('polling');

// retrieve anchor
$anchor = $pollingClient->getAnchor(array(
	'timestamp' => strtotime('-3 hours')
));

// retrieve results
$iterator = $pollingClient->getIterator('poll', array(
	'category_group' => 'JJJJ',
	'location.city' => 'USA-NYM-NEY',
	'anchor' => $anchor['anchor']
));

// iterate!
foreach($iterator as $result) {
	print_r($result);
}

// grab the anchor to use for the next poll request
$nextAnchor = $iterator->getAnchor();
```
## Testing

The project includes a basic PHPUnit test suite for each API client.

1. Install PHPUnit `php composer.phar install --dev`
2. Be sure to add your own `auth_token` to your phpunit.xml configuration
3. Run the test suite `./vendor/bin/phpunit`
