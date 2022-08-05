<?php
    interface IStorageMediaArtist
    {
        public function GetArtistCollectionIdByStorageMediaIdAndArtistId(int $smId, int $aid);
        public function GetArtistCollectionIdByStorageMediaNameAndArtistName(string $smName, string $aName);

        public function AddNewArtistCollectionEntry(int $smId, int $aId);
        public function UpdateArtistCollectionEntry(int $acId, int $newSmId, int $newArtistId);
        public function DeleteArtistCollectionEntryById(int $id);
        public function DeleteArtistCollectionEntryByArtistIdAndTitleId(int $smId, int $artistId);
    }
?>