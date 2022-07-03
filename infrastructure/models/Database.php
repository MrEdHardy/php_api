<?php 
class DataBase
{
    const helloWorld = "HelloWorld";
    protected $connection = null;
    private string $host = DB_HOST;
    private string $database = DB_DATABASE_NAME;
    private string $username = DB_USERNAME;
    private string $password = DB_PASSWORD;

    public function __construct()
    {
        $dsn = "server=:H;Database=:DB";
        $dsn = str_replace(":H", $this->host, $dsn);
        $dsn = str_replace(":DB", $this->database, $dsn);
        try {
            $this->connection = new PDO("sqlsrv:$dsn", $this->username, $this->password);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function Select($query = "", $params = [])
    {
        try {
            $stmt = $this->ExecuteStatement($query, $params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $connection = null;
            $this->connection->commit();
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }

    public function Add($query = "", $params = [])
    {
        try {
            $this->ExecuteStatement($query, $params);
            // $result = $this->GetCurrentMaxId($params[":Col"]);
            $result = $this->connection->lastInsertId();
            $this->connection->commit();
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }

    public function Update($query = "", $params = [])
    {
        try {
            $this->ExecuteStatement($query, $params);
            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }

    public function Delete($query = "", $params = [])
    {
        try {
            $this->ExecuteStatement($query, $params);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function ExecuteStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);

            if ($stmt === false) {
                throw new PDOException("Unable to prepare statement: " . $query);
            }

            if ($params) {
                foreach ($params as $key => $value) {
                    $stmt->bindParam($key, $value);
                }
            }

            $this->connection->beginTransaction();
            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function GetCurrentMaxId($column)
    {
        try {
            $stmt = $this->ExecuteStatement("SELECT MAX(Id) AS 'Identity' FROM $column");
            return $stmt->fetch(PDO::FETCH_COLUMN);
            // return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }
}
?>