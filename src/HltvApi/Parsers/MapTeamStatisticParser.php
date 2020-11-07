<?php

namespace HltvApi\Parsers;

class MapTeamStatisticParser extends Parser
{
    public function parse()
    {
        $data = [];
        $stats = $this->data->find('.stats-rows .stats-row');

        foreach ($stats as $stat) {
            $rowText = trim($stat->text());

            $arr = explode('Times played', $rowText);
            if (count($arr) === 2) {
                $data['totalMatches'] = (int)$arr[1];
                continue;
            }

            $arr = explode('Win percent', $rowText);
            if (count($arr) === 2) {
                $data['winPercent'] = (float)str_replace('%', '', $arr[1]);
                continue;
            }

            $arr = explode('CT round win percent', $rowText);
            if (count($arr) === 2) {
                $data['winPercentCT'] = (float)str_replace('%', '', $arr[1]);
                continue;
            }

            $arr = explode('T round win percent', $rowText);
            if (count($arr) === 2) {
                $data['winPercentT'] = (float)str_replace('%', '', $arr[1]);
                continue;
            }
        }
        // Парсим и считаем количество очков набранных при поражении на выбранной карте
        $loseMatches = $this->data->find('.match-lost');
        $lost_match_count = count($loseMatches);
        $scoresGainedInLose = 0;
        $meanValue = 16; // Команда не проиграла ни разу на карте
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