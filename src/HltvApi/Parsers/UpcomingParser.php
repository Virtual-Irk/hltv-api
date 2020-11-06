<?php

namespace HltvApi\Parsers;

use Exception;
use HltvApi\Entity\Match;

/**
 * Class UpcomingParser
 * @package HltvApi\Parsers
 */
class UpcomingParser extends Parser
{
    protected $days = 1;

    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     * @throws Exception
     */
    public function parse(): array
    {
        if (!$this->days) {
            throw new Exception('UpcomingParser expect integer count of days more then 0');
        }

        $idx = 0;
        $items = [];
        while ($idx < $this->days) {
            $idx++;
            $day = $this->data->find($this->config->getUpcomingMatchesContainer(), 0);
            if (!is_null($day)) {
                $items = array_merge($items, $day->find($this->config->getUpcomingMatchContainer()));
            }
        }

        return $this->fillMatchDataArray($items, Match::STATUS_UPCOMING);
    }

    public function setDays(int $days)
    {
        $this->days = $days;
    }
}