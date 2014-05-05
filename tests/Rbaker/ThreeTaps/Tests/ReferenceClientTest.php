<?php

namespace Rbaker\ThreeTaps\Tests;

use Guzzle\Tests\GuzzleTestCase;

class ReferenceClientTest extends GuzzleTestCase
{
	protected function setUp()
	{
		$this->client = $this->getServiceBuilder()->get('reference');
	}

	public function testReferenceClientInstance()
	{
		$this->assertInstanceOf('Rbaker\ThreeTaps\Reference\ReferenceClient', $this->client);
	}

	public function testSourcesRequest()
	{
		$response = $this->client->getCommand('GetSources')->getResponse();
        $this->assertTrue($response->isSuccessful());
	}

	public function testCategoryGroupsRequest()
	{
		$response = $this->client->getCommand('GetCategoryGroups')->getResponse();
        $this->assertTrue($response->isSuccessful());
	}

	public function testLocationsRequest()
	{
		$response = $this->client->getCommand('GetLocations', array(
			'level' => 'country'
		))->getResponse();
        $this->assertTrue($response->isSuccessful());
	}

	public function testLocationLookupRequest()
	{
		$response = $this->client->getCommand('LocationLookup', array(
			'code' => 'USA-AL'
		))->getResponse();
        $this->assertTrue($response->isSuccessful());
	}
}