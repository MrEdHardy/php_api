<?php
    require_once "config/bootstrap.php";
    
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    if(!isset($uri[2]) || !isset($uri[3])){
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    switch ($uri[2]) {
        case "artists":
            $controller = new ArtistController();
            $actionToCall = $uri[3]."Action";
            $controller->{$actionToCall}();
            break;
        case "titles":
            $controller = new TitleController();
            $actionToCall = $uri[3]."Action";
            $controller->{$actionToCall}();
            break;
        default:
            $objFeedController = new TestController();
            $strMethodName = $uri[3] . "Action";
            $objFeedController->{$strMethodName}();
            break;
    }
?>