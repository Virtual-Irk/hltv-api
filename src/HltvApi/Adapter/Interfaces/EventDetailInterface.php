<?php

declare(strict_types=1);

namespace HltvApi\Adapter\Interfaces;

use HltvApi\DataMapper\Map;
use HltvApi\DataMapper\Team;

interface EventDetailInterface
{
    public function getTeamByPosition(int $position): Team;

    public function getMapByPosition(int $position): Map;
}