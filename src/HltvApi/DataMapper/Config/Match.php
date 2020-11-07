<?php

declare(strict_types=1);

namespace HltvApi\DataMapper\Config;

use Exception;

class Match
{
    /** @var string */
    private $eventContainer;

    /** @var string */
    private $teamNameContainer;

    /** @var string */
    private $timeContainer;

    /** @var string */
    private $typeContainer;

    /** @var string */
    private $urlContainer;

    /**
     * Match constructor.
     * @param array $config
     * @throws Exception
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
    public function getEventContainer(): string
    {
        return $this->eventContainer;
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
    public function getTimeContainer(): string
    {
        return $this->timeContainer;
    }

    /**
     * @return string
     */
    public function getTypeContainer(): string
    {
        return $this->typeContainer;
    }

    /**
     * @return string
     */
    public function getUrlContainer(): string
    {
        return $this->urlContainer;
    }
}