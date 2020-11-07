<?php

declare(strict_types=1);

namespace HltvApi\DataMapper;

class Team
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var int $position */
    private $position;

    /** @var string $url */
    private $url;

    /** @var string $urlName */
    private $urlName;

    /**
     * Team constructor.
     * @param int $id
     * @param string $name
     * @param int $position
     * @param string $url
     * @param string $urlName
     */
    public function __construct(int $id, string $name, int $position, string $url, string $urlName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->url = $url;
        $this->urlName = $urlName;
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
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
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
    public function getUrlName(): string
    {
        return $this->urlName;
    }
}