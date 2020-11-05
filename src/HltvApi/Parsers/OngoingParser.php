<?php

namespace HltvApi\Parsers;

use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;

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
        $items = $this->data->find(self::MATCH_ONGOING_WRAPPER);

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item) {
            $data[] = $this->fillMatchDataArray($item, Match::STATUS_ONGOING);
        }
        return $data;
    }
}