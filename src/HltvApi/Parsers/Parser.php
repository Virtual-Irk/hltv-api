<?php

namespace HltvApi\Parsers;

use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class Parser
 * @package HltvApi\Parsers
 */
abstract class Parser
{
    //todo: move the settings to the config-file
    const DAY_WRAPPER = '.upcomingMatchesSection';
    const MATCH_UPCOMING_WRAPPER = '.upcomingMatch';
    const MATCH_ONGOING_WRAPPER = '.liveMatches .liveMatch .a-reset';
    const MATCH_URL_WRAPPER = '.a-reset';
    const MATCH_URL_ATTRIBUTE = 'href';
    const MATCH_TYPE_WRAPPER = '.matchMeta';
    const MATCH_TEAM_NAME_WRAPPER = '.matchTeamName';
    const MATCH_EVENT_NAME_WRAPPER = '.matchEventName';
    const MATCH_TIME_WRAPPER = '.matchTime';
    const MATCH_TIME_ATTRIBUTE = 'data-unix';

    /**
     * @var array
     */
    protected $data;

    /**
     * Parser constructor.
     * @param string $data
     */
    public function __construct(string $data)
    {
        if (!$data) {
            $this->data = [];
            return;
        }
        // look for vendor/sunra/php-simple-html-dom-parser/Src/Sunra/PhpSimple/simplehtmldom_1_5/simple_html_dom.php
        // parser required global limit const
        if (!defined('MAX_FILE_SIZE')) {
            define('MAX_FILE_SIZE', 6000000);
        }
        $this->data = HtmlDomParser::str_get_html($data);
    }

    /**
     * @return mixed
     */
    abstract public function parse();

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = HtmlDomParser::str_get_html($data);
    }

    /**
     * Internal hltv id using as unique int var per system
     *
     * @param $var
     * @return int|null
     */
    public function getId($var): ?int
    {
        $attr = explode("/", $var);
        return isset($attr[2]) ? (int)$attr[2] : null;
    }

    /**
     * Return match type look for Match const
     *
     * @param $type
     * @return int|null
     */
    public function getType($type): ?int
    {
        $lt = null;
        switch ($type) {
            case 'bo5':
                $lt = Match::TYPE_BO5;
                break;
            case 'bo3':
                $lt = Match::TYPE_BO3;
                break;
            case 'bo2':
                $lt = Match::TYPE_BO2;
                break;
            case 'bo1':
            case 'mrg':
            case 'trn':
            case 'nuke':
            case 'd2':
            case 'inf':
            case 'vtg':
            case 'ovp':
                $lt = Match::TYPE_BO1;
                break;
            default:
                $lt = Match::TYPE_UNDEFINED;
                break;
        }

        return $lt;
    }

    /**
     * @param simple_html_dom_node $item
     * @param int $status
     * @return array
     */
    public function fillMatchDataArray(simple_html_dom_node $item, int $status): array
    {
        switch ($status) {
            case Match::STATUS_ONGOING:
                $url = $item->getAttribute(self::MATCH_URL_ATTRIBUTE);
                break;
            case Match::STATUS_UPCOMING:
                $url = $item->find(self::MATCH_URL_WRAPPER, 0)->getAttribute(self::MATCH_URL_ATTRIBUTE);
                break;
            default:
                return [];
                break;
        }

        return [
            'id' => $this->getId($url),
            'status' => $status,
            'team1' => trim($item->find(self::MATCH_TEAM_NAME_WRAPPER, 0)->plaintext),
            'team2' => trim($item->find(self::MATCH_TEAM_NAME_WRAPPER, 1)->plaintext),
            'url' => $url,
            'type' => $this->getType(trim($item->find(self::MATCH_TYPE_WRAPPER, 0)->plaintext)),
            'event' => trim($item->find(self::MATCH_EVENT_NAME_WRAPPER, 0)->plaintext),
            'timestamp' => ((int)$item->find(self::MATCH_TIME_WRAPPER, 0)->getAttribute(self::MATCH_TIME_ATTRIBUTE) / 1000),
        ];
    }
}