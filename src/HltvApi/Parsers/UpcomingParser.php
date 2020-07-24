<?php

namespace HltvApi\Parsers;

use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;

/**
 * Class UpcomingParser
 * @package HltvApi\Parsers
 */
class UpcomingParser extends Parser
{
    //todo: move the settings to the config-file
    const DAY_WRAPPER = '.upcomingMatchesSection';
    const MATCH_WRAPPER = '.upcomingMatch';
    const MATCH_URL_WRAPPER = '.a-reset';
    const MATCH_URL_ATTRIBUTE = 'href';
    const MATCH_TYPE_WRAPPER = '.matchMeta';
    const MATCH_TEAM_NAME_WRAPPER = '.matchTeamName';
    const MATCH_EVENT_NAME_WRAPPER = '.matchEventName';
    const MATCH_TIME_WRAPPER = '.matchTime';
    const MATCH_TIME_ATTRIBUTE = 'data-unix';

    protected int $days = 1;

    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     * @throws \Exception
     */
    public function parse(): array
    {
        if (!$this->days) {
            throw new \Exception('UpcomingParser expect integer count of days more then 0');
        }

        $idx = 0;
        $items = [];
        while ($idx < $this->days) {
            $idx++;
            $day = $this->data->find(self::DAY_WRAPPER, 0);
            $items = array_merge($items, $day->find(self::MATCH_WRAPPER));
        }

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item) {
            $url = $item->find(self::MATCH_URL_WRAPPER, 0)->getAttribute(self::MATCH_URL_ATTRIBUTE);
            $id = $this->getId($url);
            $append = [
                'id' => $id,
                'status' => Match::STATUS_UPCOMING,
                'team1' => trim($item->find(self::MATCH_TEAM_NAME_WRAPPER, 0)->plaintext),
                'team2' => trim($item->find(self::MATCH_TEAM_NAME_WRAPPER, 1)->plaintext),
                'url' => $url,
                'type' => $this->getType(trim($item->find(self::MATCH_TYPE_WRAPPER, 0)->plaintext)),
                'event' => trim($item->find(self::MATCH_EVENT_NAME_WRAPPER, 0)->plaintext),
                'timestamp' => ((int)$item->find(self::MATCH_TIME_WRAPPER, 0)->getAttribute(self::MATCH_TIME_ATTRIBUTE) / 1000),
            ];
            $data[] = $append;
        }
        return $data;
    }

    /**
     * @param int $days
     */
    public function setDays(int $days): void
    {
        $this->days = $days;
    }
}