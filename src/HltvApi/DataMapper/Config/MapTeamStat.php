<?php

declare(strict_types=1);

namespace HltvApi\DataMapper\Config;

class MapTeamStat
{
    private $loseMatchesContainer;
    private $mainStatsContainer;
private $totalMatchesDelimiter;
private $winPercentDelimiter;
private $winPercentCTDelimiter;
private $winPercentTDelimiter;

    /**
     * @return mixed
     */
    public function getLoseMatchesContainer()
    {
        return $this->loseMatchesContainer;
    }

    /**
     * @return mixed
     */
    public function getMainStatsContainer()
    {
        return $this->mainStatsContainer;
    }

    /**
     * @return mixed
     */
    public function getTotalMatchesDelimiter()
    {
        return $this->totalMatchesDelimiter;
    }

    /**
     * @return mixed
     */
    public function getWinPercentDelimiter()
    {
        return $this->winPercentDelimiter;
    }

    /**
     * @return mixed
     */
    public function getWinPercentCTDelimiter()
    {
        return $this->winPercentCTDelimiter;
    }

    /**
     * @return mixed
     */
    public function getWinPercentTDelimiter()
    {
        return $this->winPercentTDelimiter;
    }
}