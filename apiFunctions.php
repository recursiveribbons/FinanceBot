<?php
require_once 'config.php';
define('TG_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

function tgRequest($fields) {
    $ch = curl_init(TG_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $result = curl_exec ($ch);
    curl_close ($ch);
    return json_decode($result, true);
}

function sendMessage($chat, $message) {
    $param = array(
        'method' => 'sendMessage',
        'chat_id' => $chat,
        'text' => $message,
        'parse_mode' => 'Markdown',
    );
    return tgRequest($param);
}

function getCsv() {
    $array = array_map('str_getcsv', file('data.csv', FILE_SKIP_EMPTY_LINES));
    array_shift($array);
    return $array;
}

function writeFile($array) {
    $file = fopen("data.csv", "a") or die("Unable to open file!");
    $result = fputcsv($file, $array);
    fclose($file);
    return $result;
}

function addItem($input) {
    $item = explode(" ", $input, 2);
    $array = [time(), floatval($item[0]), $item[1]]; // timestamp, value, name
    $result = writeFile($array);
    if(!$result) {
        sendMessage(TG_USER_ID, "Error!");
    } else {
        $status = getStatus();
        $message = <<< _END
Added spending
$status
_END;
        sendMessage(TG_USER_ID, $message);
    }
}

function removeLastItem() {
    $lines = file('data.csv');
    $last = count($lines) - 1 ;
    unset($lines[$last]);
    $file = fopen('data.csv', 'w');
    $result = fwrite($file, implode('', $lines));
    fclose($file);
    if(!$result) {
        sendMessage(TG_USER_ID, "Error!");
    } else {
        $status = getStatus();
        $message = <<< _END
Removed spending
$status
_END;
        sendMessage(TG_USER_ID, $message);
    }
}

function sendStatus() {
    $message = getStatus();
    sendMessage(TG_USER_ID, $message);
}

function listSpending() {
    date_default_timezone_set("Europe/Berlin");
    $array = getCsv();
    $sum = 0;
    $monthname = date('F');
    $message = "Spending for $monthname\n";
    $date = new DateTime(date('Y-m') . "-01"); //get first day of this month
    $timestamp = $date->getTimestamp();
    foreach ($array as $row) {
        $time = intval($row[0]);
        if($timestamp <= $time) {
            $time_text = date('d H:i', $time);
            $amount = sprintf('%.2f', floatval($row[1]));
            $name = $row[2];
            $message .= "$time_text €$amount $name\n";
            $sum += floatval($row[1]);
        }
    }
    $amount = sprintf('%.2f', $sum);
    $message .= "Total: €$amount";
    sendMessage(TG_USER_ID, $message);
}

function getStatus() {
    date_default_timezone_set("Europe/Berlin");
    $array = getCsv();
    $sum = 0;
    $monthname = date('F');
    $date = new DateTime(date('Y-m') . "-01"); //get first day of this month
    $timestamp = $date->getTimestamp();
    foreach ($array as $row) {
        if($timestamp <= intval($row[0])) {
            $sum += floatval($row[1]);
        }
    }
    $amount = sprintf('%.2f', $sum);
    $message = "€$amount spent in $monthname";
    return $message;
}

function toEuro($twd) {
    sendMessage(TG_USER_ID, '€'.sprintf('%.2f', $twd/36));
}
function toTWD($euro) {
    sendMessage(TG_USER_ID, '$'.sprintf('%.2f', $euro*36));
}

function sendID($chat_id) {
    sendMessage($chat_id, "Your user ID is $chat_id");
}