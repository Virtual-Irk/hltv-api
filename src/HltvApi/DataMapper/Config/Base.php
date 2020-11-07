<?php

declare(strict_types=1);

namespace HltvApi\DataMapper\Config;

use Exception;

class Base
{
    /** @var array */
    private $mapMapping;

    /** @var array */
    private $proxyList;

    /**
     * Base constructor.
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
     * @return array
     */
    public function getMapMapping(): array
    {
        return $this->mapMapping;
    }

    /**
     * @return array
     */
    public function getProxyList(): array
    {
        return $this->proxyList;
    }
}