<?php

namespace HltvApi\Entity;

/**
 * Class Match
 * @package HltvApi\Entity
 */
class Match extends Entity
{
    const STATUS_UPCOMING = 1;
    const STATUS_LIVE = 2;
    const STATUS_PASSED = 3;

    const STATUS_NAME = [
        self::STATUS_UPCOMING => 'upcoming',
        self::STATUS_LIVE => 'live',
        self::STATUS_PASSED => 'passed',
    ];

    const TYPE_UNDEFINED = -1;
    const TYPE_BO1 = 1;
    const TYPE_BO2 = 2;
    const TYPE_BO3 = 3;
    const TYPE_BO5 = 4;

    const TYPE_NAME = [
        self::TYPE_UNDEFINED => 'undefined',
        self::TYPE_BO1 => 'bo1',
        self::TYPE_BO2 => 'bo2',
        self::TYPE_BO3 => 'bo3',
        self::TYPE_BO5 => 'bo5',
    ];

    protected $details;

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->getValue('id');
    }

    /**
     * @return string
     */
    public function getTeam1(): string
    {
        return $this->getValue('team1');
    }

    /**
     * @return string
     */
    public function getTeam2(): string
    {
        return $this->getValue('team2');
    }

    /**
     * @return string
     */
    public function getMatchUrl(): string
    {
        return $this->getValue('url');
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->getValue('event');
    }

    /**
     * @return int
     */
    public function getStatus(): string
    {
        return $this->getValue('status');
    }

    /**
     * @return int
     */
    public function getWinner(): ?int
    {
        return $this->getValue('winner');
    }

    /**
     * @return array
     */
    public function getResult(): ?array
    {
        return $this->getValue('result');
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return (int)$this->getValue('timestamp');
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return (int)$this->getValue('type');
    }

    /**
     * @return Entity|MatchDetails
     * @throws \Exception
     */
    public function details(): MatchDetails
    {
        return $this->details ?? $this->details = $this->client->matchDetails($this->getMatchUrl());
    }
}