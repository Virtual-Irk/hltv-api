<?php

declare(strict_types=1);

namespace HltvApi\DataMapper\Config;

use Exception;

class Url
{
    /** @var string */
    private $baseUrl;

    /** @var string */
    private $mapStatRoute;

    /** @var string */
    private $matchesRoute;

    /** @var string */
    private $resultsRoute;

    /**
     * Url constructor.
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
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getMapStatRoute(): string
    {
        return $this->mapStatRoute;
    }

    /**
     * @return string
     */
    public function getMatchesRoute(): string
    {
        return $this->matchesRoute;
    }

    /**
     * @return string
     */
    public function getResultsRoute(): string
    {
        return $this->resultsRoute;
    }
}