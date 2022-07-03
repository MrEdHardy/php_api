<?php 
    interface IArtistTitle 
    {
        // Achtung UNIQUE Index bei TitleCollection für TitelId und KünstlerId!!!
        public function GetTitleCollectionIdByArtistIdAndTitleId(int $titleId, int $artistId);
        public function GetTitleCollectionIdByArtistNameAndTitleName(string $titleName, string $artistName);
        // ...
        public function AddNewTitleCollectionEntry(int $titleId, int $artistId);
        public function UpdateTitleCollectionEntry(int $tcId, int $newTitleId, int $newArtistId);
        public function DeleteTitleCollectionEntryById(int $id);
        public function DeleteTitleCollectionEntryByArtistIdAndTitleId(int $titleId, int $artistId);
    }
?>