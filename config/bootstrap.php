<?php
    require_once "config.php";
    require_once "infrastructure/interfaces/IArtist.php";
    require_once "infrastructure/interfaces/IArtistTitle.php";
    require_once "infrastructure/interfaces/IEntity.php";
    require_once "infrastructure/interfaces/ITitle.php";
    require_once "infrastructure/interfaces/IStorageMedia.php";
    require_once "infrastructure/interfaces/IStorageMediaArtist.php";
    require_once "infrastructure/interfaces/IMedium.php";
    require_once "infrastructure/interfaces/IMediumMediumCollection.php";
    require_once "infrastructure/models/Database.php";
    require_once "infrastructure/models/TestModel.php";
    require_once "infrastructure/models/Artist.php";
    require_once "infrastructure/models/Title.php";
    require_once "infrastructure/models/Location.php";
    require_once "infrastructure/models/StorageMedia.php";
    require_once "infrastructure/models/Medium.php";
    require_once "infrastructure/controller/BaseController.php";
    require_once "infrastructure/controller/TestController.php";
    require_once "infrastructure/controller/ArtistController.php";
    require_once "infrastructure/controller/TitleController.php";
    require_once "infrastructure/controller/LocationController.php";
    require_once "infrastructure/controller/StorageMediaController.php";
    require_once "infrastructure/controller/MediumController.php";
?>