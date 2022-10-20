<?php
    enum DateModeEnum : int
    {
        case Equals = 0;
        case Greater = 1;
        case Lesser = 2;
        case GreaterOrEqual = 4;
        case LesserOrEqual = 8;
        case Between = 16;
    }

    class StorageMedia extends DataBase implements IEntity, IStorageMedia, IStorageMediaArtist, IStorageMediaMediumCollection
    {
        public function GetAllEntities()
        {
            return $this->Select("SELECT * FROM Musikträger ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->Select("SELECT * FROM Musikträger WHERE Id = :Id", array(":Id" => $id));
        }

        public function UpdateEntity(int $id, array $args)
        {
            $querySets = "";
            foreach ($args as $key => $value) 
            {
                if(strcasecmp($key, "Id") != 0)
                    $querySets .= "$key='$value',";
            }
            $querySets[strlen($querySets) - 1] = " ";
            $querySets = trim($querySets);
            $query = "UPDATE Musikträger SET $querySets WHERE Id = $id";
            return array("successful" => $this->Update($query));
        }

        public function AddEntity(array $args)
        {
            $queryColumns = "";
            $queryValues = "";
            foreach ($args as $key => $value) 
            {
                if(strcasecmp($key, "Id") != 0)
                {
                    $queryColumns .= "$key,";
                    $queryValues .= "'$value',";
                }
            }
            $queryColumns[strlen($queryColumns) - 1] = " ";
            $queryValues[strlen($queryValues) - 1] = " ";
            $queryColumns = trim($queryColumns);
            $queryValues = trim($queryValues);
            $query = "INSERT INTO Musikträger($queryColumns) VALUES($queryValues)";
            $mergedObject = array_merge($args, array("Id" => $this->Add($query)));
            return $mergedObject;
        }

        /**
         * DML DELETE will go over Mediumcollection to delete a storage medium
         */
        public function DeleteEntity(int $id)
        {
            $this->Delete("DELETE FROM Musikträger WHERE Id = :Id", array(":Id" => $id));
            return array("successful" => true);
        }

        public function GetCurrentId()
        {
            return $this->GetCurrentMaxId("Musikträger");
        }

        public function GetStorageMediaByGenre(string $genre)
        {
            return $this->Select("SELECT * FROM Musikträger WHERE Genre = :Genre", array(":Genre" => $genre));
        }

        public function GetStorageMediaByDate(array $args)
        {
            if(!isset($args["Mode"]))
                throw new Exception("Mode is not set!");
            if(!isset($args["Dates"]))
                throw new Exception("Date is not set!");
            $mode = $args["Mode"];
            $operator = "";
            if(DateModeEnum::tryFrom($mode) !== DateModeEnum::Between)
            {
                if(!is_array($args["Dates"]))
                {
                    $dates = $args["Dates"];
                }
                else
                {
                    $dates = $args["Dates"][0];
                }

                // return $this->Select($query, array(":date" => $dates));
                if(DateModeEnum::tryFrom($mode) === DateModeEnum::Equals)
                {
                    $operator = "=";
                }
                elseif(DateModeEnum::tryFrom($mode) === DateModeEnum::Greater)
                {
                    $operator = ">";
                }
                elseif(DateModeEnum::tryFrom($mode) === DateModeEnum::Lesser)
                {
                    $operator = "<";
                }
                elseif(DateModeEnum::tryFrom($mode) === DateModeEnum::GreaterOrEqual)
                {
                    $operator = ">=";
                }
                elseif(DateModeEnum::tryFrom($mode) === DateModeEnum::LesserOrEqual)
                {
                    $operator = "<=";
                }
                else 
                {
                    throw new Exception("Mode is invalid!");
                }

                $query = "SELECT * FROM Musikträger WHERE [Kaufdatum] $operator :date";
                return $this->Select($query, array(":date" => $dates));
            }
            else
            {
                if(!is_array($args["Dates"]) || count($args["Dates"]) < 2)
                    throw new Exception("Two Dates are required!");
                $dates = $args["Dates"];
                if(count($dates) > 2)
                    throw new Exception("Not more than two Dates can be used!");
                $date1 = $dates[0];
                $date2 = $dates[1];
                return $this->Select("SELECT * FROM Musikträger WHERE [Kaufdatum] BETWEEN :date1 AND :date2", 
                array(":date1" => $date1, ":date2" => $date2));
            }
        }

        public function GetStorageMediaByArtistId(int $id)
        {
            return $this->Select("SELECT mt.* FROM Musikträger mt
            INNER JOIN KünstlerCollection kc ON kc.MusikträgerId = mt.Id
            INNER JOIN Künstler k ON k.Id = kc.KünstlerId
            WHERE k.Id = :Id", array(":Id" => $id));
        }

        public function GetStorageMediaByArtistName(string $name)
        {
            return $this->Select("SELECT mt.* FROM Musikträger mt
            INNER JOIN KünstlerCollection kc ON kc.MusikträgerId = mt.Id
            INNER JOIN Künstler k ON k.Id = kc.KünstlerId
            WHERE k.[Name] = :name", array(":name" => $name));
        }

        public function DeleteStorageMediaByName(string $name)
        {
            $this->Delete("DELETE FROM Musikträger WHERE [Name] = :name", array(":name" => $name));
            return array("successful" => true);
        }

        public function GetAllArtistCollections()
        {
            return $this->Select("SELECT * FROM [KünstlerCollection] ORDER BY Id ASC");
        }

        public function GetArtistCollectionById(int $id)
        {
            return $this->Select("SELECT * FROM [KünstlerCollection] WHERE Id = :Id", array(":Id" => $id));
        }

        public function GetArtistCollectionIdByStorageMediaIdAndArtistId(int $smId, int $aid)
        {
            return $this->Select("SELECT kc.Id FROM Musikträger mt
            INNER JOIN KünstlerCollection kc ON kc.MusikträgerId = mt.Id
            INNER JOIN Künstler k ON k.Id = kc.KünstlerId
            WHERE k.Id = :kId AND mt.Id = :smId", array(":kId" => $aid, ":smId" => $smId));
        }

        public function GetArtistCollectionIdByStorageMediaNameAndArtistName(string $smName, string $aName)
        {
            return $this->Select("SELECT kc.Id FROM Musikträger mt
            INNER JOIN KünstlerCollection kc ON kc.MusikträgerId = mt.Id
            INNER JOIN Künstler k ON k.Id = kc.KünstlerId
            WHERE k.[Name] = :kName AND mt.[Name] = :smName", array(":kName" => $aName, ":smName" => $smName));
        }

        public function AddNewArtistCollectionEntry(int $smId, int $aId)
        {
            $args = array("KünstlerId" => "$aId", "MusikträgerId" => "$smId");
            $mergedObject = array_merge($args, array("Id" => $this->Add("INSERT INTO KünstlerCollection VALUES(:kId, :smId)", array(":kId" => $aId, ":smId" => $smId))));
            return $mergedObject;
        }

        public function UpdateArtistCollectionEntry(int $acId, int $newSmId, int $newArtistId)
        {
            return array("successful" => $this->Update("UPDATE KünstlerCollection SET KünstlerId = :kId, MusikträgerId = :smId WHERE Id = :Id ", 
            array(":kId" => $newArtistId, ":smId" => $newSmId, ":Id" => $acId)));
        }

        public function DeleteArtistCollectionEntryById(int $id)
        {
            $this->Delete("DELETE FROM KünstlerCollection WHERE Id = :Id", array(":Id" => $id));
            return array("successful" => true);
        }

        public function DeleteArtistCollectionEntryByArtistIdAndTitleId(int $smId, int $artistId)
        {
            $this->Delete("DELETE FROM KünstlerCollection WHERE KünstlerId = :kId AND MusikträgerId = :smId", 
            array(":kId" => $artistId, ":smId" => $smId));
            return array("successful" => true);
        }

        public function GetStorageMediaByMediumCollectionId(int $id)
        {
            return $this->Select("SELECT * FROM Musikträger WHERE Id IN (SELECT MusikträgerId FROM Mediumcollection WHERE Id = :Id)", array(":Id" => $id));
        }
    }
?>