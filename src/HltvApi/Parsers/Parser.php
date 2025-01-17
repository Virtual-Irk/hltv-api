<?php

namespace HltvApi\Parsers;


use HltvApi\Config;
use HltvApi\DataMapper\Event;
use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class Parser
 * @package HltvApi\Parsers
 */
abstract class Parser
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Parser constructor.
     * @param string $data
     * @param Config $config
     */
    public function __construct(string $data, Config $config)
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
        $this->config = $config;
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
     * Internal hltv team url name using as string var per system
     *
     * @param $var
     * @return string|null
     */
    public function getTeamNameFromUrl($var): ?string
    {
        $attr = explode("/", $var);
        return isset($attr[3]) ? trim($attr[3]) : null;
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
     * @param simple_html_dom_node[]|array $items
     * @param int $status
     * @return array
     */
    public function fillMatchDataArray(array $items, int $status): array
    {
        $data = [];
        foreach ($items as $item) {
            switch ($status) {
                case Match::STATUS_LIVE:
                case Match::STATUS_UPCOMING:
                    $url = trim($item->find($this->config->match->getUrlContainer(), 0)->getAttribute($this->config->attributes->getHref()));
                    break;
                default:
                    continue;
            }

            if (isset($url)) {
                $id = (int)$this->getId($url);
                $eventNameContainer = $item->find($this->config->match->getEventContainer(), 0);
                if (!is_null($eventNameContainer)) {
                    $name = trim($item->find($this->config->match->getEventContainer(), 0)->text());
                    $firstTeamName = trim($item->find($this->config->match->getTeamNameContainer(), 0)->text());
                    $secondTeamName = trim($item->find($this->config->match->getTeamNameContainer(), 1)->text());
                } else {
                    $name = $item->find('.matchInfoEmpty', 0)->text();
                    $firstTeamName = $secondTeamName = 'TBA';
                }

                $type = (int)$this->getType(trim($item->find($this->config->match->getTypeContainer(), 0)->text()));
                $timestamp = (int)($item->find($this->config->match->getTimeContainer(), 0)->getAttribute($this->config->attributes->getDataUnix()) / 1000);

                $data[] = new Event($id, $name, $url, $firstTeamName, $secondTeamName, $status, $type, $timestamp);
            }
        }

        $this->data->clear();
        return $data;
    }
}