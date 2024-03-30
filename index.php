<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once './routes/Router.php';
$link = $_SERVER['REQUEST_URI'];
$parsed =  parse_url($link, PHP_URL_PATH);
$urlTab = explode("/", $parsed);
$baseUrl = $urlTab[1];
$url = $urlTab[2];

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    if ($url == "" || $url=="homepage") {
        $url = "";
    }



}else{

    $url = array_key_last($_POST);
    if (is_null($url) && isset($_FILES)) {
        $url ="picture";
    }
}


Router::route($method, $url);
