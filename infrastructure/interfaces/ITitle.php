<?php
    interface ITitle
    {
        public function GetTitleByArticleId(int $id);
        public function GetTitleByArticleName(string $name);
    }
?>