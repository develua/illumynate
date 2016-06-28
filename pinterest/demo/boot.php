<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "../autoload.php";

  //  $dotenv = new Dotenv/Dotenv(__DIR__);
  //  $dotenv->load();

    $pinterest = new DirkGroenen\Pinterest\Pinterest(getenv("4840065063708536804"), getenv("7972d111367ef6b5d969207a500995a64c8523703ccd8761d1f58a5dc54920d1"));

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
