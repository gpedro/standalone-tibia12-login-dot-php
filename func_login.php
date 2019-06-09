<?php

function login($obj) {
    global $gameserver;
    $username = $obj->accountname;
    $password = sha1($obj->password);
    $token = $obj->token ?? false;

    $account = mysql_select_single("SELECT `id`, `premdays` FROM `accounts` WHERE `name`='{$username}' AND `password`='{$password}' LIMIT 1;");
    if ($account === false) {
        return jsonError('Wrong username and/or password.');
    }

    $players = mysql_select_multi("SELECT `name`, `level`, `vocation`, `sex`,`looktype`, `lookhead`, `lookbody`, `looklegs`, `lookfeet`, `lookaddons` FROM `players` WHERE `account_id`='{$account['id']}';");
    if ($players !== false) {
        // TODO: token before password
        $sessionKey = $username."\n".$obj->password;
        $response = [];
        $response['session'] = [
            'fpstracking' => false,
            'optiontracking' => false,
            'isreturner' => true,
            'returnernotification' => false,
            'showrewardnews' => false,
            'sessionkey' => $sessionKey,
            'lastlogintime' => 0,
            'ispremium' => !!$account['premdays'],
            'premiumuntil' => time() + ($account['premdays'] * 86400),
            'status' => 'active'
        ];
        $response['playdata'] = [];
        $response['playdata']['worlds'] = [];
        $response['playdata']['characters'] = [];

        $response['playdata']['worlds'][] = [
            'id' => 0,
            'name' => $gameserver['name'],
            'externaladdress' => $gameserver['ip'],
            'externalport' => $gameserver['port'],
            'previewstate' => 0,
            'location' => 'ALL',
            'externaladdressunprotected' => $gameserver['ip'],
            'externaladdressprotected' => $gameserver['ip'],
            'externalportunprotected' => $gameserver['port'],
            'externalportprotected' => $gameserver['port'],
            'anticheatprotection' => false
        ];
        foreach ($players as $player) {
            $response['playdata']['characters'][] = array(
                'worldid' => 0,
                'name' => $player['name'],
                'level' => $player['level'],
                'ismale' => $player['sex'] === 1,
                'tutorial' => false,
                'vocation' => parse_vocation($player),
                'outfitid' => intval($player['looktype']),
                'headcolor' => intval($player['lookhead']),
                'torsocolor' => intval($player['lookbody']),
                'legscolor' => intval($player['looklegs']),
                'detailcolor' => intval($player['lookfeet']),
                'addonsflags' => intval($player['lookaddons'])
                // 'ishidden' => false
            );
        }
        //error_log("= SESSION KEY: " . $response['session']['sessionkey']);
        return json_encode($response);
    } else {
        return jsonError("Character list is empty.");
    }

}
