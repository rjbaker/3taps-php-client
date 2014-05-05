<?php

namespace Rbaker\ThreeTaps\Tests;

use Guzzle\Tests\GuzzleTestCase;

class SearchClientTest extends GuzzleTestCase
{
	protected function setUp()
	{
		$this->client = $this->getServiceBuilder()->get('search');
	}

	public function testSearchClientInstance()
	{
		$this->assertInstanceOf('Rbaker\ThreeTaps\Search\SearchClient', $this->client);
	}

	public function testSearchResultIteratorInstance()
	{
		$iterator = $this->client->getIterator('search', array(
			'category_group' => 'JJJJ'
		));

		$this->assertInstanceOf('Rbaker\ThreeTaps\Search\Iterator\SearchIterator', $iterator);

		return $iterator;
	}
}