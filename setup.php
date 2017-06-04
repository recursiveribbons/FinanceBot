<?php
require_once 'apiFunctions.php';
$param = array(
    'method' => 'setWebhook',
    'url' => "https://example.com/pathtobot/webhook.php",
    'allowed_updates' => array('message')
);
print_r(tgRequest($param));