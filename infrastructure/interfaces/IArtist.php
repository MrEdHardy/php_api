<?php
    interface IArtist 
    {
        public function GetArtistsByTitleId(int $id);
        public function GetArtistsByTitleName(string $name);
        public function DeleteArtistByName(string $name);
    }
?>