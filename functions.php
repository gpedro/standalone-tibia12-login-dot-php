<?php

// Useful functions
function parse_vocation(array $player): string {
    global $vocations;

    $vocation_id = intval($player['vocation']);
    return $vocations[$player['vocation']] ?? "Unknown (Vocation Id {$vocation_id}";
}

// ZnoteAAC Database Helpers
// Connect to Database using old mysql driver (mysqli)
function db_connect(): void {
    global $connect, $sqlHost, $sqlUser, $sqlPassword, $sqlDatabase;
    $connect = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
    if ($connect->connect_errno) {
        echo "(" . $connect->connect_errno . ") " . $connect->connect_error;
    }
}

// Select single row from database
function mysql_select_single($query) {
    global $connect;
    $result = mysqli_query($connect,$query);
    if (!$result) {
        echo mysqli_error($connect);
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    return !empty($row) ? $row : false;
}
// Selecting multiple rows from database.
function mysql_select_multi($query){
    global $connect;
    $array = array();
    $results = mysqli_query($connect,$query);
    if (!$results) {
        echo mysqli_error($connect);
        return false;
    }

    while($row = mysqli_fetch_assoc($results)) {
        $array[] = $row;
    }
    return !empty($array) ? $array : false;
}

// Client 11 loginWebService
function jsonError($message, $code = 3) {
    return json_encode(array('errorCode' => $code, 'errorMessage' => $message));
}
