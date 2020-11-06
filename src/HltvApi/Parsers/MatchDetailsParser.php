<?php

namespace HltvApi\Parsers;

/**
 * Class MatchDetailsParser
 * @package HltvApi\Parsers
 */
class MatchDetailsParser extends Parser
{
    const ODDS_PROVIDERS = [
        'egb-nolink',
    ];

    /**
     * Parse implementation of Parser base class. Should returning a row of match details data
     * @throws \Exception
     */
    public function parse(): array
    {
        foreach (static::ODDS_PROVIDERS as $name) {

            $selector = ".{$name} .odds-cell";
            $odds1 = $this->data->find($selector, 0);
            $odds2 = $this->data->find($selector, 2);

            if ($odds1 && $odds2) {
                $odds1 = (double)trim($odds1->text());
                $odds2 = (double)trim($odds2->text());
                break;
            }
        }

        $maps = $this->data->find('.maps .mapholder');
        $mapsResult = [];
        $mapsNames = [];

        $time = $this->data->find('.timeAndEvent .countdown', 0)->text();

        foreach ($maps as $i => $map) {
            $mapN = $i + 1;
            $name = $map->find('.mapname', 0)->text();
            $mapsNames["map{$mapN}name"] = $name;

            if ($map->find('.results', 0)) {
                $mapsResult["map{$mapN}pikedByTeam1"] = !is_null($map->getElementByTagName('div.pick'));
                $mapsResult["map{$mapN}pikedByTeam2"] = !is_null($map->getElementByTagName('span.pick'));
                $mapsResult["map{$mapN}score1"] = trim($map->find('.results-left .results-team-score', 0)->text());
                $mapsResult["map{$mapN}score2"] = trim($map->find('.results-right .results-team-score', 0)->text());
            }

        }

        $hhBlock = $this->data->find('.head-to-head', 0);
        if ($hhBlock) {
            $team1Wins = (int)$hhBlock->find('div.bold', 0)->text();
            $team2Wins = (int)$hhBlock->find('div.bold', 1)->text();
            $totalMatches = $team1Wins + $team2Wins;
            $oneMatchWinPercent = ($totalMatches > 0) ? 100 / $totalMatches : 0;
            $winPercentTeam1 = round($oneMatchWinPercent * $team1Wins, 2);
            $winPercentTeam2 = round($oneMatchWinPercent * $team2Wins, 2);
        } else {
            $winPercentTeam1 = $winPercentTeam2 = 0;
        }

        $result = [
            'odds' => [$odds1, $odds2],
            'time_start' => $time,
            'win_percent_team_1' => $winPercentTeam1,
            'win_percent_team_2' => $winPercentTeam2,
        ];

        $this->data->clear();
        return array_merge($result, $mapsResult, $mapsNames);
    }
}