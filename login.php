<?php

header("Content-Type: application/json");

ob_start();

require_once 'config.php';
require_once 'functions.php';
require_once 'func_login.php';

db_connect();

$input = json_decode(file_get_contents("php://input"));
$request_id = time();
file_put_contents("log/{$request_id}-request", json_encode($input, JSON_PRETTY_PRINT));

switch ($input->type ?? '') {

    case 'cacheinfo':
        global $statistics;
        echo json_encode($statistics);
    break;

    case 'eventschedule':
        global $schedule;
        echo json_encode($schedule);
        break;

    case 'boostedcreature':
        $boostedcreature["boostedcreature"] = true;
		$boostedcreature["raceid"] = 15;
        echo json_encode($boostedcreature);
        break;

    case 'login':
        echo login($input);
        break;

    default:
        return jsonError("Unrecognized event.");

}

$response = ob_get_contents();
ob_end_clean();
file_put_contents("log/{$request_id}-response", print_r($response, true));
die($response);
