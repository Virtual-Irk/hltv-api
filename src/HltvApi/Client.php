<?php

namespace HltvApi;

use Exception;
use HltvApi\DataMapper\Event;
use HltvApi\DataMapper\EventDetail;
use HltvApi\DataMapper\TeamMapStatistic;
use HltvApi\Entity\Match;
use HltvApi\Interfaces\Request;
use HltvApi\Parsers\MapTeamStatisticParser;
use HltvApi\Parsers\EventDetailsParser;
use HltvApi\Parsers\LiveParser;
use HltvApi\Parsers\Parser;
use HltvApi\Parsers\ResultsParser;
use HltvApi\Parsers\UpcomingParser;
use HltvApi\Wrappers\BaseWrapper;

/**
 * Class Client
 * @package HltvApi
 */
class Client implements Request
{
    /**
     * Array for proxy list (optional)
     * [
     *  ['0.0.0.0', '80', CURLPROXY_SOCKS5],
     *  ['0.0.0.0', '8080', CURLPROXY_SOCKS5],
     * ]
     * @var array
     */
    protected $proxyList;

    /** @var Config */
    protected $config;

    /**
     * Client constructor.
     * @param string|null $configPath
     * @throws Exception
     */
    public function __construct(string $configPath = null)
    {
        $this->config = is_null($configPath) ? new Config() : new Config($configPath);
        $this->proxyList = $this->config->base->getProxyList();
    }

    /**
     * @return string
     */
    public function getUrlMatches(): string
    {
        return $this->config->url->getBaseUrl() . $this->config->url->getMatchesRoute();
    }

    /**
     * @return string
     */
    public function getUrlResults(): string
    {
        return $this->config->url->getBaseUrl() . $this->config->url->getResultsRoute();
    }

    /**
     * @param $link
     * @return string
     */
    public function getUrlDetails($link): string
    {
        return $this->config->url->getBaseUrl() . $link;
    }

    /**
     * @param int $mapId
     * @param int $teamId
     * @param string $teamName
     * @return string
     */
    public function getUrlMapStatistic(int $mapId, int $teamId, string $teamName): string
    {
        $url = $this->config->url->getBaseUrl() . $this->config->url->getMapStatRoute();
        $dateFrom = date('Y-m-d', mktime(0, 0, 0, date('m') - 6, date('d')));
        $dateTo = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')));

        $url = str_replace('MAP_ID', $mapId, $url);
        $url = str_replace('TEAM_ID', $teamId, $url);
        $url = str_replace('TEAM_NAME', $teamName, $url);
        $url = str_replace('DATE_FROM', $dateFrom, $url);
        $url = str_replace('DATE_TO', $dateTo, $url);

        return $url;
    }

    /**
     * @return Proxy|null
     */
    public function createProxy()
    {
        if (!count($this->proxyList)) {
            return null;
        }

        $idx = count($this->proxyList) - 1;
        $idx = rand(0, $idx);

        return new Proxy($this->proxyList[$idx]);
    }

    /**
     * @param null $url
     * @param string $method
     * @return string
     */
    public function sendRequest($url = null, $method = 'GET'): string
    {
        $result = '';
        if ($ch = curl_init()) {
            $proxy = $this->createProxy();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 180);
            if ($proxy) {
                curl_setopt($ch, CURLOPT_PROXY, "{$proxy->ip()}:{$proxy->port()}");
                curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy->type());
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        if (!$result && is_array($this->proxyList) && count($this->proxyList)) {
            return $this->sendRequest($url, $method);
        }
        return $result;
    }

    /**
     * Making a Parser object of same type whom implements parse method
     * @param string $type
     * @param string $url
     * @return Parser
     * @throws \Exception
     */
    public function createDataParser(string $type, string $url): Parser
    {
        if (!class_exists($type)) {
            throw new Exception('The requested type of parser is not exists');
        }
        if (!is_subclass_of($type, Parser::class)) {
            throw new Exception('The requested parser should be children of Parser::class');
        }

        return (new $type($this->sendRequest($url), $this->config));
    }

    /**
     * Getting an live list of Match objects
     * @return Event[]
     * @throws Exception
     */
    public function getLiveMatchesList(): array
    {
        $parser = $this->createDataParser(LiveParser::class, $this->getUrlMatches());
        return $parser->parse();
    }

    /**
     * Getting an upcoming list of Event-objects for x days at the scheduler
     *
     * @param int $days
     * @return Event[]
     * @throws Exception
     */
    public function getUpcomingMatchesList($days = 2): array
    {
        /** @var UpcomingParser $parser */
        $parser = $this->createDataParser(UpcomingParser::class, $this->getUrlMatches());
        $parser->setDays($days);
        return $parser->parse();
    }

    /**
     * @param string $url
     * @return EventDetail
     * @throws Exception
     */
    public function getEventDetail(string $url): EventDetail
    {
        $parser = $this->createDataParser(EventDetailsParser::class, $this->getUrlDetails($url));
        return $parser->parse();
    }

    /**
     * Getting a result list of Match-objects
     *
     * @return Match[]|array|null
     * @throws \Exception
     */
    public function results(): array
    {
        $parser = $this->createDataParser(ResultsParser::class, $this->getUrlResults());
        return (new BaseWrapper(Match::class, $parser->parse(), $this))->fetchList();
    }

    /**
     * @param int $mapId
     * @param int $teamId
     * @param string $teamName
     * @return TeamMapStatistic
     * @throws Exception
     */
    public function getMapTeamStatistic(int $mapId, int $teamId, string $teamName): TeamMapStatistic
    {
        $parser = $this->createDataParser(MapTeamStatisticParser::class, $this->getUrlMapStatistic($mapId, $teamId, $teamName));
        $data = $parser->parse();

        return new TeamMapStatistic($teamId, $mapId, $data['totalMatches'], $data['totalLostMatches'], $data['meanFailScores'], $data['winPercent'], $data['winPercentCT'], $data['winPercentT']);
    }
}