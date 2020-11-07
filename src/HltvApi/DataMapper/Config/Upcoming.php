<?php

declare(strict_types=1);

namespace HltvApi\DataMapper\Config;

use Exception;

class Upcoming
{
    /** @var string */
    private $matchesContainer;

    /** @var string */
    private $matchContainer;

    /**
     * Upcoming constructor.
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
    public function getMatchesContainer(): string
    {
        return $this->matchesContainer;
    }

    /**
     * @return string
     */
    public function getMatchContainer(): string
    {
        return $this->matchContainer;
    }
}