<?php
    interface IEntity {
        public function GetAllEntities();
        public function GetEntityById(int $id);
        public function UpdateEntity(int $id, array $keyValuePairs);
        public function AddEntity(array $keyValuePairs);
        public function DeleteEntity(int $id);
        public function GetCurrentId();
    }
?>