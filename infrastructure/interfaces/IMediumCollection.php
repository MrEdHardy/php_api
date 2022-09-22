<?php
    interface IMediumCollection
    {
        public function GetMediumCollectionsByType(string $type);
        public function GetMediumCollectionsByMediumId(int $medId);
        public function GetMediumCollectionsByStorageMediaId(int $smId);
        public function GetMediumCollectionsByTitleCollectionId(int $tcId);
    }
?>