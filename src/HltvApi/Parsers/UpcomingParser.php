<?php
namespace HltvApi\Parsers;

use Exception;
use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;

/**
 * Class UpcomingParser
 * @package HltvApi\Parsers
 */
class UpcomingParser extends Parser
{
    protected $days = 1;

    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     * @throws \Exception
     */
    public function parse() : array
    {
        if(!$this->days) {
            throw new Exception('UpcomingParser expect integer count of days more then 0');
        }

        $idx = 0;
        $items = [];
        while ($idx < $this->days) {
            $idx++;
            $day = $this->data->find($this->config->getUpcomingMatchesContainer(), 0);
            if (!is_null($day)) {
                $items = array_merge($items, $day->find($this->config->getUpcomingMatchContainer()));
            }
        }

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item) {
            $urlContainer = $item->find($this->config->getUpcomingUrlContainer(), 0);
            if (is_null($urlContainer)) {
                continue;
            }
            $url = $urlContainer->getAttribute($this->config->getAttributeHref());
            $id = $this->getId($url);
            $matchTypeContainer = $item->find($this->config->getUpcomingMatchTypeContainer(), 0);
            if (is_null($matchTypeContainer)) {
                continue;
            }
            $type = $this->getType(trim($matchTypeContainer->text()));
            $team1Container = $item->find($this->config->getUpcomingTeamOneContainer(), 0);
            $team2Container = $item->find($this->config->getUpcomingTeamTwoContainer(), 0);
            $eventContainer = $item->find($this->config->getUpcomingEventContainer(), 0);
            $team1 = !is_null($team1Container) ? trim($team1Container->text()) : '';
            $team2 = !is_null($team2Container) ? trim($team2Container->text()) : '';
            $event = !is_null($eventContainer) ? trim($eventContainer->text()) : '';

            $matchTimeContainer = $item->find($this->config->getUpcomingMatchTimeContainer(), 0);

            $timestamp = ((int)$matchTimeContainer->getAttribute($this->config->getAttributeDataUnix()) / 1000);
            $append = [
                'id' => $id,
                'status' => Match::STATUS_UPCOMING,
                'team1' => $team1,
                'team2' => $team2,
                'url' => $url,
                'type' => $type,
                'event' => $event,
                'timestamp' => $timestamp,
            ];
            $data[] = $append;
        }
        return $data;
    }

    public function setDays(int $days)
    {
        $this->days = $days;
    }
}