<?php

declare(strict_types=1);

namespace HltvApi\DataMapper;

class Map
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var int $position */
    private $position;

    /**
     * Map constructor.
     * @param int $id
     * @param string $name
     * @param int $position
     */
    public function __construct(int $id, string $name, int $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
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
}