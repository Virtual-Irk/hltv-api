<?php

declare(strict_types=1);

namespace HltvApi\DataMapper;

class EventDetail
{
    /** @var Team[] */
    private $teams;

    /** @var Map[] */
    private $maps;

    /**
     * EventDetail constructor.
     * @param Team[] $teams
     * @param Map[] $maps
     */
    public function __construct(array $teams, array $maps)
    {
        $this->teams = $teams;
        $this->maps = $maps;
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    /**
     * @return Map[]
     */
    public function getMaps(): array
    {
        return $this->maps;
    }
}