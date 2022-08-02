<?php
    interface ITitle
    {
        public function GetTitlesByArticleId(int $id);
        public function GetTitlesByArticleName(string $name);
        public function DeleteTitlesByName(string $name);
    }
?>