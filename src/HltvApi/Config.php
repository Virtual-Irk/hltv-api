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

    public function getAttributeDataUnix(): ?string
    {
        return isset($this->config['attributes']['dataUnix']) ? $this->config['attributes']['dataUnix'] : null;
    }

    public function getAttributeHref(): ?string
    {
        return isset($this->config['attributes']['href']) ? $this->config['attributes']['href'] : null;
    }

    public function getMatchBaseContainer(): ?string
    {
        return isset($this->config['match']['baseContainer']) ? $this->config['match']['baseContainer'] : null;
    }

    public function getMatchEventContainer(): ?string
    {
        return isset($this->config['match']['eventContainer']) ? $this->config['match']['eventContainer'] : null;
    }

    public function getMatchTeamNameContainer(): ?string
    {
        return isset($this->config['match']['teamNameContainer']) ? $this->config['match']['teamNameContainer'] : null;
    }

    public function getMatchTimeContainer(): ?string
    {
        return isset($this->config['match']['timeContainer']) ? $this->config['match']['timeContainer'] : null;
    }

    public function getMatchTypeContainer(): ?string
    {
        return isset($this->config['match']['typeContainer']) ? $this->config['match']['typeContainer'] : null;
    }

    public function getMatchUrlContainer(): ?string
    {
        return isset($this->config['match']['urlContainer']) ? $this->config['match']['urlContainer'] : null;
    }

    public function getUpcomingMatchContainer(): ?string
    {
        return isset($this->config['upcoming']['matchContainer']) ? $this->config['upcoming']['matchContainer'] : null;
    }
}