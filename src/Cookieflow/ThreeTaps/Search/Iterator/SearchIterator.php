<?php

namespace Cookieflow\ThreeTaps\Search\Iterator;

use Guzzle\Service\Resource\ResourceIterator;

class SearchIterator extends ResourceIterator
{
	/**
     * @var string search result anchor
     */
	protected $anchor;

	/**
	 * @var int search result tier
	 */
	protected $nextTier;

	/**
	 * @var int total number or search matches
	 */
	protected $numMatches;

	protected function sendRequest()
    {
        // If a next token is set, then add it to the command
        if ($this->nextToken) {
            $this->command->set('page', $this->nextToken);
            $this->command->set('anchor', $this->anchor);
            $this->command->set('tier', $this->nextTier);
        }

        // Execute the command and parse the result
        $result = $this->command->execute();

        // Parse the next token
        $this->nextToken = isset($result['next_page']) ? $result['next_page'] : false;
        if(isset($result['anchor'])) $this->anchor = $result['anchor'];
        if(isset($result['next_tier'])) $this->nextTier = $result['next_tier'];
        if(isset($result['num_matches'])) $this->numMatches = $result['num_matches'];

        return $result['postings'];
    }

	/**
	 * @return string
	 */
    public function getAnchor()
    {
		return $this->anchor;
    }

	/**
	 * @return int
	 */
    public function getNextTier()
    {
    	return (int)$this->nextTier;
    }

    /**
     * @return int
     */
    public function getNumMatches()
    {
		return (int)$this->numMatches;
    }


}