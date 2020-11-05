<?php

namespace HltvApi\Entity;

/**
 * Class MatchDetails
 * @package HltvApi\Entity
 */
class MatchDetails extends Match
{
    const IS_LIVE = 'LIVE';
    const IS_OVER = 'Match over';
    const IS_POSTPONED = 'Match postponed';

    /**
     * Getting a match -up type, declared in parent entity Match
     * @return null|int
     */
    public function getType(): ?int
    {
        return parent::getType();
    }

    /**
     * Getting unix timestamp of match time
     * @return null|int
     */
    public function getMatchTimeStart(): ?int
    {
        return (int)$this->getValue('time_start') ?? null;
    }

    /**
     * @return array|null
     */
    public function getOdds(): ?array
    {
        return $this->getValue('odds');
    }

    /**
     * @param int $map
     * @return bool
     */
    public function getMapStarted(int $map): bool
    {
        $score1 = $this->getValue("map{$map}score1", 0);
        $score2 = $this->getValue("map{$map}score2", 0);
        if ($map > 1) {
            $map = $map - 1;
            if ($this->getMapResults($map)) {
                return true;
            }
        }
        return ($score1 + $score2 > 0);
    }

    /**
     * @param int $map
     * @return array|null
     */
    public function getMapResults(int $map): ?array
    {
        $score1 = $this->getValue("map{$map}score1", 0);
        $score2 = $this->getValue("map{$map}score2", 0);

        if ((($score1 != $score2) && ($score1 > 15 || $score2 > 15))
            || (($score1 + $score2 > 30) && abs($score1 - $score2) > 3)) {
            return [$score1, $score2];
        }
        return null;
    }

    /**
     * @param int $map
     * @return array
     */
    public function getMapScore(int $map): array
    {
        $score1 = $this->getValue("map{$map}score1", 0);
        $score2 = $this->getValue("map{$map}score2", 0);
        return [$score1, $score2];
    }

    /**
     * @param int $map
     * @return string|null
     */
    public function getMapName(int $map): ?string
    {
        return $this->getValue("map{$map}name") ?? null;
    }

    /**
     * @return boolean
     */
    public function getMatchIsLive(): bool
    {
        return $this->getValue('time_start') == self::IS_LIVE;
    }

    /**
     * @return boolean
     */
    public function getMatchIsOver(): bool
    {
        return $this->getValue('time_start') == self::IS_OVER;
    }

    public function getTeam1WinPercent(): ?float
    {
        return $this->getValue('win_percent_team_1');
    }

    public function getTeam2WinPercent(): ?float
    {
        return $this->getValue('win_percent_team_2');
    }

    public function getTeamNumberPickedTheMap(int $mapNumber): ?int
    {
        $teamNumber = null;
        if ($this->getValue("map{$mapNumber}pikedByTeam1")) {
            $teamNumber = 1;
        }
        if ($this->getValue("map{$mapNumber}pikedByTeam2")) {
            $teamNumber = 2;
        }
        return $teamNumber;
    }
}