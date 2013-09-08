3taps-php-client
================

A PHP 5.3+ client for working with the 3taps APIs.

## Usage

### Create a service instance

```php
use Cookieflow\ThreeTaps\ThreeTapsService;

$service = ThreeTapsService::factory(array(
	'auth_token' => 'your-private-auth-token'
));
```





