<?php

declare(strict_types=1);

namespace HltvApi\DataMapper\Config;

use Exception;

class MatchDetail
{
    /** @var string */
    private $mapsContainer;

    /** @var string */
    private $mapNameContainer;

    /** @var string */
    private $teamNameContainer;

    /** @var string */
    private $teamUrlContainer;

    /**
     * MatchDetail constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach ($config as $property => $value) {
            if (property_exists(self::class, $property)) {
                $this->{$property} = $value;
            } else {
                throw new Exception('Class has no property "' . $property . '"');
            }
        }
    }

    /**
     * @return string
     */
    public function getMapsContainer(): string
    {
        return $this->mapsContainer;
    }

    /**
     * @return string
     */
    public function getMapNameContainer(): string
    {
        return $this->mapNameContainer;
    }

    /**
     * @return string
     */
    public function getTeamNameContainer(): string
    {
        return $this->teamNameContainer;
    }

    /**
     * @return string
     */
    public function getTeamUrlContainer(): string
    {
        return $this->teamUrlContainer;
    }
}