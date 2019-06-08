<?php

$connect = null;

$sqlHost = '127.0.0.1';
$sqlUser = 'root';
$sqlPassword = 'root';
$sqlDatabase = 'otserv';

$gameserver = [
    'ip' => '127.0.0.1',
    'port' => 7172,
    'name' => 'GPEDRO' // should be same servername declared in config.lua
];

// ??
$boostedcreature = ['race_id' => 2];

// fake statistics data
$statistics = [
    'playersonline' => 123,
    'twitchstreams' => 456,
    'twitchviewer' => 678,
    'gamingyoutubestreams' => 910,
    'gamingyoutubeviewer' => 112
];

// fake event list
// not working.
$schedule = [
    'eventlist' => [
        ['startdate' => time(), 'endate' => time() + 3600 * 3, 'colorlight' => '#ffcc00', 'colordark' => '#000000', 'name' => 'OTServBR Global', 'description' => 'Chupa John', 'isseasonal' => false],
        ['startdate' => time() + 36000, 'endate' => time() + 3600 * 6, 'colorlight' => '#000000', 'colordark' => '#ffcc00', 'name' => 'otserv.com.br', 'description' => 'melhor forum', 'isseasonal' => false]
    ]
];

// vocation list
$vocations = [
    'None', 'Sorcerer', 'Druid', 'Paladin', 'Knight',
    'Master Sorcerer', 'Elder Druid', 'Royal Paladin', 'Elite Knight'
];
