<?php

namespace HltvApi\Parsers;

use HltvApi\Entity\Match;

/**
 * Class OngoingParser
 * @package HltvApi\Parsers
 */
class OngoingParser extends Parser
{
    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     */
    public function parse(): array
    {
        $items = $this->data->find($this->config->getMatchBaseContainer());

        return $this->fillMatchDataArray($items, Match::STATUS_ONGOING);
    }
}