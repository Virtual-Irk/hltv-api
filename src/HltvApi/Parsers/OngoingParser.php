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
            $url = $item->getAttribute('href');
            $id = $this->getId($url);
            $append = [
                'id' => $id,
                'status' => Match::STATUS_ONGOING,
                'team1' => trim($item->find(self::MATCH_TEAM_NAME_WRAPPER, 0)->plaintext),
                'team2' => trim($item->find(self::MATCH_TEAM_NAME_WRAPPER, 1)->plaintext),
                'url' => $url,
                'type' => $this->getType(trim($item->find(self::MATCH_TYPE_WRAPPER, 0)->plaintext)),
            ];
            $data[] = $append;
        }
        return $data;
    }
}