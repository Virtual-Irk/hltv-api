<?php

declare(strict_types=1);

namespace HltvApi\DataMapper;

class Event
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $url;

    /** @var string */
    private $firstTeamName;

    /** @var string */
    private $secondTeamName;

    /** @var int */
    private $status;

    /** @var int */
    private $type;

    /** @var int */
    private $timestamp;

    /**
     * Event constructor.
     * @param int $id
     * @param string $name
     * @param string $url
     * @param string $firstTeamName
     * @param string $secondTeamName
     * @param int $status
     * @param int $type
     * @param int $timestamp
     */
    public function __construct(int $id, string $name, string $url, string $firstTeamName, string $secondTeamName, int $status, int $type, int $timestamp)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->firstTeamName = $firstTeamName;
        $this->secondTeamName = $secondTeamName;
        $this->status = $status;
        $this->type = $type;
        $this->timestamp = $timestamp;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getFirstTeamName(): string
    {
        return $this->firstTeamName;
    }

    /**
     * @return string
     */
    public function getSecondTeamName(): string
    {
        return $this->secondTeamName;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}