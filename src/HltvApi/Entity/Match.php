<?php

namespace HltvApi\Entity;

/**
 * Class Match
 * @package HltvApi\Entity
 */
class Match extends Entity
{
    const STATUS_UPCOMING = 1;
    const STATUS_ONGOING = 2;
    const STATUS_PASSED = 3;

    const STATUS_NAME = [
        self::STATUS_UPCOMING => 'upcoming',
        self::STATUS_ONGOING => 'ongoing',
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return (int)$this->getValue('id') ?? null;
    }

    /**
     * @return string|null
     */
    public function getTeam1(): ?string
    {
        return trim($this->getValue('team1')) ?? null;
    }

    /**
     * @return string|null
     */
    public function getTeam2(): ?string
    {
        return trim($this->getValue('team2')) ?? null;
    }

    /**
     * @return string|null
     */
    public function getMatchUrl(): ?string
    {
        return trim($this->getValue('url')) ?? null;
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return trim($this->getValue('event')) ?? null;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return (int)$this->getValue('status') ?? null;
    }

    /**
     * @return string|null
     */
    public function getStatusName(): ?string
    {
        return trim(self::STATUS_NAME[$this->getValue('status')]) ?? null;
    }

    /**
     * @return int|null
     */
    public function getWinner(): ?int
    {
        return (int)$this->getValue('winner') ?? null;
    }

    /**
     * @return array|null
     */
    public function getResult(): ?array
    {
        return $this->getValue('result') ?? null;
    }

    /**
     * @return int|null
     */
    public function getTimestamp(): ?int
    {
        return (int)$this->getValue('timestamp') ?? null;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return (int)$this->getValue('type') ?? null;
    }

    /**
     * @return string|null
     */
    public function getTypeName(): ?string
    {
        return trim(self::TYPE_NAME[$this->getValue('type')]) ?? null;
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