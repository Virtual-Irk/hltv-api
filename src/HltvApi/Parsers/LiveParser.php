<?php

namespace HltvApi\Parsers;

use HltvApi\Entity\Match;

/**
 * Class OngoingParser
 * @package HltvApi\Parsers
 */
class LiveParser extends Parser
{
    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     */
    public function parse(): array
    {
        $items = $this->data->find($this->config->getLiveMatchesContainer());

        return $this->fillMatchDataArray($items, Match::STATUS_LIVE);
    }
}