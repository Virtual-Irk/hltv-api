<?php

declare(strict_types=1);

namespace HltvApi\DataMapper;

class TeamMapStatistic
{
    /** @var int */
    private $teamId;

    /** @var int */
    private $mapId;

    /** @var int */
    private $totalMatches;

    /** @var int */
    private $totalLostMatches;

    /** @var float */
    private $meanFailScores;

    /** @var float */
    private $winPercent;

    /** @var float */
    private $winPercentCT;

    /** @var float */
    private $winPercentT;

    /**
     * TeamMapStatistic constructor.
     * @param int $teamId
     * @param int $mapId
     * @param int $totalMatches
     * @param int $totalLostMatches
     * @param float $meanFailScores
     * @param float $winPercent
     * @param float $winPercentCT
     * @param float $winPercentT
     */
    public function __construct(int $teamId, int $mapId, int $totalMatches, int $totalLostMatches, float $meanFailScores, float $winPercent, float $winPercentCT, float $winPercentT)
    {
        $this->teamId = $teamId;
        $this->mapId = $mapId;
        $this->totalMatches = $totalMatches;
        $this->totalLostMatches = $totalLostMatches;
        $this->meanFailScores = $meanFailScores;
        $this->winPercent = $winPercent;
        $this->winPercentCT = $winPercentCT;
        $this->winPercentT = $winPercentT;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->teamId;
    }

    /**
     * @return int
     */
    public function getMapId(): int
    {
        return $this->mapId;
    }

    /**
     * @return int
     */
    public function getTotalMatches(): int
    {
        return $this->totalMatches;
    }

    /**
     * @return int
     */
    public function getTotalLostMatches(): int
    {
        return $this->totalLostMatches;
    }

    /**
     * @return float
     */
    public function getMeanFailScores(): float
    {
        return $this->meanFailScores;
    }

    /**
     * @return float
     */
    public function getWinPercent(): float
    {
        return $this->winPercent;
    }

    /**
     * @return float
     */
    public function getWinPercentCT(): float
    {
        return $this->winPercentCT;
    }

    /**
     * @return float
     */
    public function getWinPercentT(): float
    {
        return $this->winPercentT;
    }
}