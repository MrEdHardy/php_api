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
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function Select($query = "", $params = [])
    {
        try {
            $stmt = $this->ExecuteStatement($query, $params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $connection = null;

            return $result;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        return false;
    }

    public function Add($query = "", $params = [])
    {
        try {
            $this->ExecuteStatement($query, null);
            // $result = $stmt->fetch(PDO::FETCH_COLUMN);
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $this->GetCurrentMaxId($params[":Col"]);
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
                throw new PDOException("Unable to do prepared statement: " . $query);
            }

            if ($params) {
                foreach ($params as $key => $value) {
                    $stmt->bindParam($key, $value);
                }
            }

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function GetCurrentMaxId($column)
    {
        try {
            $stmt = $this->ExecuteStatement("SELECT MAX(Id) AS 'Identity' FROM $column", null);
            return $stmt->fetch(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw $e;
        }
        return false;
    }
}
?>