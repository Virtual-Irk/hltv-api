<?php
namespace HltvApi\Parsers;


/**
 * Class MatchDetailsParser
 * @package HltvApi\Parsers
 */
class MatchDetailsParser extends Parser
{

    /**
     * Parse implementation of Parser base class. Should returning a row of match details data
     * @throws \Exception
     */
    public function parse() : array
    {

        $odds1 = $this->data->find('.betting-listing .egb-nolink .odds-cell', 0);
        $odds2 = $this->data->find('.betting-listing .egb-nolink .odds-cell', 2);

        if($odds1 && $odds2)  {
            $odds1 = (int) trim($odds1->text());
            $odds2 = (int) trim($odds2->text()) ;
        }

        $maps = $this->data->find('.maps .mapholder');
        $mapsResult = [];

        foreach ($maps as $i => $map) {
            $result = $map->find('.results', 0)->text();
            $result = explode('(', $result);
            $result = isset($result[0]) ? $result[0] : null;
            if($result) {
                $result = explode(':', $result);
            }
            $i++;
            $mapsResult["map{$i}score1"] = isset($result[0]) ? $result[0] : null;
            $mapsResult["map{$i}score2"] = isset($result[1]) ? $result[1] : null;
        }

        $result = [
            'odds' => [$odds1, $odds2],
        ];

        return array_merge($result, $mapsResult);
    }

}