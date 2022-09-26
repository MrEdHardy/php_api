<?php 
    interface IArtistTitle 
    {
        // Achtung UNIQUE Index bei TitleCollection für TitelId und KünstlerId!!! wird nicht mehr benötigt
        public function GetTitleCollectionIdByArtistIdAndTitleId(int $titleId, int $artistId);
        public function GetTitleCollectionIdByArtistNameAndTitleName(string $titleName, string $artistName);
        // ...
        public function AddNewTitleCollectionEntry(array $args);
        public function UpdateTitleCollectionEntry(int $tcId, array $args);
        public function DeleteTitleCollectionEntryById(int $id);
        public function DeleteTitleCollectionEntryByArtistIdAndTitleId(int $titleId, int $artistId);
    }
?>