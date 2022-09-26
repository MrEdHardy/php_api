<?php
    require_once "config/bootstrap.php";
    
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    if(!isset($uri[2]) || !isset($uri[3])){
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $actionToCall = $uri[3]."Action";
    switch ($uri[2]) {
        case "artists":
            $controller = new ArtistController();
            $controller->{$actionToCall}();
            break;
        case "titles":
            $controller = new TitleController();
            $controller->{$actionToCall}();
            break;
        case "locations":
            $controller = new LocationController();
            $controller->{$actionToCall}();
            break;
        case "storagemedia":
            $controller = new StorageMediaController();
            $controller->{$actionToCall}();
            break;
        case "media":
            $controller = new MediumController();
            $controller->{$actionToCall}();
            break;
        case "mediumcollection":
            $controller = new MediumCollectionController();
            $controller->{$actionToCall}();
            break;
        default:
            $objFeedController = new TestController();
            $strMethodName = $uri[3] . "Action";
            $objFeedController->{$strMethodName}();
            break;
    }
?>