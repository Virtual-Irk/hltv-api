<?php

namespace HltvApi;

class Config
{
    /** @var array */
    private $config;

    /**
     * Config constructor.
     *
     * @param string $configPath
     */
    public function __construct(string $configPath)
    {
        $this->config = require $configPath;
    }

    public function getUpcomingMatchesContainer(): ?string
    {
        return isset($this->config['upcoming']['matchesContainer']) ? $this->config['upcoming']['matchesContainer'] : null;
    }

    public function getUpcomingMatchContainer(): ?string
    {
        return isset($this->config['upcoming']['matchContainer']) ? $this->config['upcoming']['matchContainer'] : null;
    }

    public function getUpcomingUrlContainer(): ?string
    {
        return isset($this->config['upcoming']['urlContainer']) ? $this->config['upcoming']['urlContainer'] : null;
    }

    public function getAttributeHref(): ?string
    {
        return isset($this->config['attributes']['href']) ? $this->config['attributes']['href'] : null;
    }

    public function getAttributeDataUnix(): ?string
    {
        return isset($this->config['attributes']['dataUnix']) ? $this->config['attributes']['dataUnix'] : null;
    }

    public function getUpcomingMatchTypeContainer(): ?string
    {
        return isset($this->config['upcoming']['matchTypeContainer']) ? $this->config['upcoming']['matchTypeContainer'] : null;
    }

    public function getUpcomingTeamOneContainer(): ?string
    {
        return isset($this->config['upcoming']['teamOneContainer']) ? $this->config['upcoming']['teamOneContainer'] : null;
    }

    public function getUpcomingTeamTwoContainer(): ?string
    {
        return isset($this->config['upcoming']['teamTwoContainer']) ? $this->config['upcoming']['teamTwoContainer'] : null;
    }

    public function getUpcomingEventContainer(): ?string
    {
        return isset($this->config['upcoming']['eventContainer']) ? $this->config['upcoming']['eventContainer'] : null;
    }

    public function getUpcomingMatchTimeContainer(): ?string
    {
        return isset($this->config['upcoming']['matchTimeContainer']) ? $this->config['upcoming']['matchTimeContainer'] : null;
    }
}