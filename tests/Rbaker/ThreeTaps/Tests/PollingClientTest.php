<?php

namespace Rbaker\ThreeTaps\Tests;

use Guzzle\Tests\GuzzleTestCase;

class PollingClientTest extends GuzzleTestCase
{
	protected function setUp()
	{
		$this->client = $this->getServiceBuilder()->get('polling');
	}

	public function testPollingClientInstance()
	{
		$this->assertInstanceOf('Rbaker\ThreeTaps\Polling\PollingClient', $this->client);
	}

	public function testAnchorRequest()
	{
		$response = $this->client->getCommand('getAnchor', array(
			'timestamp' => strtotime('-4 hours')
		))->getResponse();

        $this->assertTrue($response->isSuccessful());

        $result = $response->json();
        return $result['anchor'];
	}

	/**
	 *	@depends testAnchorRequest
	 */
	public function testPollIteratorInstance($anchor)
	{
		$iterator = $this->client->getIterator('poll', array(
			'category_group' => 'JJJJ',
			'anchor' => $anchor
		));

		$this->assertInstanceOf('Rbaker\ThreeTaps\Polling\Iterator\PollIterator', $iterator);

		return $iterator;
	}

	/**
	 * @depends testPollIteratorInstance
	 */
	 public function testPollIteratorResult($iterator)
	 {
	 	$iterator->setLimit(10);
	 	$this->assertCount(10, $iterator->toArray());
	 }
}