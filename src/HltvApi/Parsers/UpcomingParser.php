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
    /** @var int */
    protected $days = 1;

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays(int $days): void
    {
        $this->days = $days;
    }

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
            $items = array_merge($items, $day->find(self::MATCH_UPCOMING_WRAPPER));
        }

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item) {
            $data[] = $this->fillMatchDataArray($item, Match::STATUS_UPCOMING);
        }
        return $data;
    }
}