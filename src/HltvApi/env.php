<?php

return [
    'base' => [
        'mapMapping' => [
            'vertigo' => 46,
            'dust2' => 31,
            'cobblestone' => 39,
            'nuke' => 34,
            'inferno' => 33,
            'mirage' => 32,
            'cache' => 29,
            'train' => 35,
            'overpass' => 40,
        ],
        /**
         * Array for proxy list (optional)
         * [
         *  ['0.0.0.0', '80', CURLPROXY_SOCKS5],
         *  ['0.0.0.0', '8080', CURLPROXY_SOCKS5],
         * ]
         */
        'proxyList' => [],
    ],
    'attributes' => [
        'dataUnix' => 'data-unix',
        'href' => 'href',
    ],
    'live' => [
        'matchesContainer' => '.liveMatch',
    ],
    'mapTeamStat' => [
        'loseMatchesContainer' => '.match-lost',
        'mainStatsContainer' => '.stats-rows .stats-row',
        'totalMatchesDelimiter' => 'Times played',
        'winPercentDelimiter' => 'Win percent',
        'winPercentCT' => 'CT round win percent',
        'winPercentT' => 'T round win percent',
    ],
    'match' => [
        'eventContainer' => '.matchEventName',
        'teamNameContainer' => '.matchTeamName',
        'timeContainer' => 'div.matchTime',
        'typeContainer' => '.matchMeta',
        'urlContainer' => '.a-reset',
    ],
    'matchDetail' => [
        'mapsContainer' => '.maps .mapholder',
        'mapNameContainer' => '.mapname',
        'teamNameContainer' => '.teamsBox .team .teamName',
        'teamUrlContainer' => '.teamsBox .team a',
    ],
    'upcoming' => [
        'matchesContainer' => '.upcomingMatchesContainer .upcomingMatchesSection',
        'matchContainer' => '.upcomingMatch',
    ],
    'url' => [
        'baseUrl' => 'https://hltv.org',
        'mapStatRoute' => '/stats/teams/map/MAP_ID/TEAM_ID/TEAM_NAME?startDate=DATE_FROM&endDate=DATE_TO',
        'matchesRoute' => '/matches',
        'resultsRoute' => '/results',
    ],
];