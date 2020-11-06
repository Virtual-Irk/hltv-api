<?php

declare(strict_types=1);

namespace HltvApi\Adapter;

use Exception;
use HltvApi\Adapter\Interfaces\EventDetailInterface;
use HltvApi\DataMapper\EventDetail;
use HltvApi\DataMapper\Map;
use HltvApi\DataMapper\Team;

class EventDetailAdapter implements EventDetailInterface
{
    /** @var EventDetail $eventDetail */
    protected $eventDetail;

    /**
     * EventDetailAdapter constructor.
     * @param EventDetail $eventDetail
     */
    public function __construct(EventDetail $eventDetail)
    {
        $this->eventDetail = $eventDetail;
    }

    /**
     * @param int $position
     * @return Team
     * @throws Exception
     */
    public function getTeamByPosition(int $position): Team
    {
        foreach ($this->eventDetail->getTeams() as $team) {
            if ($team->getPosition() === $position) {
                return $team;
            }
        }

        throw new Exception('Can not find team on position');
    }

    /**
     * @param int $position
     * @return Map
     * @throws Exception
     */
    public function getMapByPosition(int $position): Map
    {
        foreach ($this->eventDetail->getMaps() as $map) {
            if ($map->getPosition() === $position) {
                return $map;
            }
        }

        throw new Exception('Can not find map on position');
    }

}