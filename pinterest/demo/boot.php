<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    composer require "dirkgroenen/Pinterest-API-PHP:0.2.11";

    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    $pinterest = new DirkGroenen\Pinterest\Pinterest(getenv("4847323402507141362"), getenv("887cbc52dcace78c709908b679049d348e45b4fc3f77d7db013897d5d1e0cc27"));

    if (isset($_GET["code"])) {
        $token = $pinterest->auth->getOAuthToken($_GET["code"]);
        $pinterest->auth->setOAuthToken($token->access_token);

        setcookie("access_token", $token->access_token);
    } else if (isset($_GET["access_token"])) {
        $pinterest->auth->setOAuthToken($_GET["access_token"]);
    } else if (isset($_COOKIE["access_token"])) {
        $pinterest->auth->setOAuthToken($_COOKIE["access_token"]);
    } else {
        assert(false);
    }

?>
