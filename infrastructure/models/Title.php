<?php
    class Title extends DataBase implements IEntity, ITitle, IArtistTitle
    {
        public function GetAllEntities()
        {

        }

        public function GetEntityById(int $id)
        {

        }

        public function UpdateEntity(int $id, array $keyValuePairs)
        {

        }

        public function AddEntity(array $keyValuePairs)
        {

        }
        public function DeleteEntity(int $id)
        {

        }
        public function GetCurrentId()
        {

        }

        public function GetTitleCollectionIdByArtistIdAndTitleId(int $titleId, int $artistId)
        {

        }

        public function GetTitleCollectionIdByArtistNameAndTitleName(string $titleName, string $artistName)
        {

        }

        public function AddNewTitleCollectionEntry(int $titleId, int $artistId)
        {

        }

        public function UpdateTitleCollectionEntry(int $tcId, int $newTitleId, int $newArtistId)
        {

        }

        public function DeleteTitleCollectionEntryById(int $id)
        {

        }

        public function DeleteTitleCollectionEntryByArtistIdAndTitleId(int $titleId, int $artistId)
        {

        }

        public function GetTitleByArticleId(int $id)
        {

        }

        public function GetTitleByArticleName(string $name)
        {

        }
    }
?>