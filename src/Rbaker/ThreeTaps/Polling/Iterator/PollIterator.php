<?php

namespace Cookieflow\ThreeTaps\Polling\Iterator;

use Guzzle\Service\Resource\ResourceIterator;

class PollIterator extends ResourceIterator
{
	/**
	 * @var int total number or search matches
	 */
	protected $numMatches;

	protected function sendRequest()
    {
        // If a next token is set, then add it to the command
        if ($this->nextToken) {
            $this->command->set('anchor', $this->nextToken);
        }

        // Execute the command and parse the result
        $result = $this->command->execute();

        // Parse the next token
        $this->nextToken = isset($result['anchor']) ? $result['anchor'] : false;

        return isset($result['postings']) ? $result['postings'] : array();
    }

    public function getAnchor()
    {
    	return $this->nextToken;
    }
}