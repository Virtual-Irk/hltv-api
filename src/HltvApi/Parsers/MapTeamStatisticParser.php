<?php

namespace HltvApi\Parsers;

class MapTeamStatisticParser extends Parser
{
    public function parse(): array
    {
        $data = [];
        $mapTeamStatConfig = $this->config->mapTeamStat;
        $stats = $this->data->find($mapTeamStatConfig->getMainStatsContainer());

        foreach ($stats as $stat) {
            $rowText = trim($stat->text());

            $arr = explode($mapTeamStatConfig->getTotalMatchesDelimiter(), $rowText);
            if (count($arr) === 2) {
                $data['totalMatches'] = (int)$arr[1];
                continue;
            }

            $arr = explode($mapTeamStatConfig->getWinPercentDelimiter(), $rowText);
            if (count($arr) === 2) {
                $data['winPercent'] = (float)str_replace('%', '', $arr[1]);
                continue;
            }

            $arr = explode($mapTeamStatConfig->getWinPercentCTDelimiter(), $rowText);
            if (count($arr) === 2) {
                $data['winPercentCT'] = (float)str_replace('%', '', $arr[1]);
                continue;
            }

            $arr = explode($mapTeamStatConfig->getWinPercentTDelimiter(), $rowText);
            if (count($arr) === 2) {
                $data['winPercentT'] = (float)str_replace('%', '', $arr[1]);
                continue;
            }
        }
        // Parse and count the number of points scored in case of defeat on the selected card
        $loseMatches = $this->data->find($mapTeamStatConfig->getLoseMatchesContainer());
        $lost_match_count = count($loseMatches);
        $scoresGainedInLose = 0;
        $meanValue = 16; // The team has never lost on the map
        if ($lost_match_count > 0) {
            foreach ($loseMatches as $loseMatch) {
                $matchScoreArr = array_map(function ($item) {
                    return (int)($item);
                }, explode(' - ', trim($loseMatch->text())));
                $scoresGainedInLose += min($matchScoreArr);
            }
            $meanValue = round($scoresGainedInLose / $lost_match_count, 2);
        }

        $data['meanFailScores'] = (float)$meanValue;
        $data['totalLostMatches'] = (int)$lost_match_count;

        return $data;
    }
}