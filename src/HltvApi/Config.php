<?php

namespace HltvApi;

use Exception;
use HltvApi\DataMapper\Config\Attributes;
use HltvApi\DataMapper\Config\Base;
use HltvApi\DataMapper\Config\Live;
use HltvApi\DataMapper\Config\MapTeamStat;
use HltvApi\DataMapper\Config\Match;
use HltvApi\DataMapper\Config\MatchDetail;
use HltvApi\DataMapper\Config\Upcoming;
use HltvApi\DataMapper\Config\Url;

/**
 * Class Config
 * @package HltvApi
 */
class Config
{
    const DEFAULT_CONFIG = __DIR__ . '/env.php';

    /** @var Attributes */
    public $attributes;

    /** @var Base */
    public $base;

    /** @var Live */
    public $live;

    /** @var Match */
    public $match;

    /** @var MapTeamStat */
    public $mapTeamStat;

    /** @var MatchDetail */
    public $matchDetail;

    /** @var Upcoming */
    public $upcoming;

    /** @var Url */
    public $url;

    /**
     * Config constructor.
     * @param string|null $configPath
     * @throws Exception
     */
    public function __construct(string $configPath = null)
    {
        $cfg = file_exists($configPath) ? $configPath : self::DEFAULT_CONFIG;
        $config = require $cfg;

        $properties = array_keys(get_class_vars(self::class));
        foreach ($properties as $property) {
            if (!isset($config[$property])) {
                throw new Exception('Config file must contain "' . $property . '"');
            } else {
                try {
                    $className = 'HltvApi\DataMapper\Config\\' . ucfirst($property);
                    $this->{$property} = new $className($config[$property]);
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
        }
    }
}