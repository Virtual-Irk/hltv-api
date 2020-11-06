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

    /**
     * Team constructor.
     * @param int $id
     * @param string $name
     * @param int $position
     * @param string $url
     */
    public function __construct(int $id, string $name, int $position, string $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->url = $url;
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
}