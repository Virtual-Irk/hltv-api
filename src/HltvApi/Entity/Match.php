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
     * @return int
     */
    public function getId()
    {
        return $this->getValue('id');
    }

    /**
     * @return string
     */
    public function getTeam1()
    {
        return $this->getValue('team1');
    }

    /**
     * @return string
     */
    public function getTeam2()
    {
        return $this->getValue('team2');
    }

    /**
     * @return string
     */
    public function getMatchUrl()
    {
        return $this->getValue('url');
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->getValue('event');
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->getValue('status');
    }

    /**
     * @return string|null
     */
    public function getStatusName(): ?string
    {
        return isset(self::STATUS_NAME[$this->getValue('status')]) ? self::STATUS_NAME[$this->getValue('status')] : null;
    }

    /**
     * @return int
     */
    public function getWinner()
    {
        return $this->getValue('winner');
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->getValue('result');
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->getValue('timestamp');
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->getValue('type');
    }

    /**
     * @return string|null
     */
    public function getTypeName(): ?string
    {
        return isset(self::TYPE_NAME[$this->getValue('type')]) ? self::TYPE_NAME[$this->getValue('type')] : null;
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