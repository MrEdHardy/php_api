<?php
    require_once "config/bootstrap.php";
    // echo "Banane\n";
    // echo DB_HOST."\n";
    // echo getcwd()."\n";
    // echo DataBase::helloWorld;
    // echo "\n This is Database:TestModel::helloWorld".TestModel::helloWorld."\n";
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    // if ((isset($uri[2]) && $uri[2] != 'test') || !isset($uri[3])) {
    //     header("HTTP/1.1 404 Not Found");
    //     exit();
    // }

    if(!isset($uri[2]) || !isset($uri[3])){
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $objFeedController = new TestController();
    $strMethodName = $uri[3] . 'Action';
    $objFeedController->{$strMethodName}();
?>