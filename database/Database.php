<?php

namespace database;
use PDO;
use PDOException;

class Database{

    private $connection;
    private $dbName = DB_NAME;
    private $dbHost = DB_HOST;
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;
    private $options = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
    ];

    public function __construct(){

        try {

            $this->connection = new PDO(
               "mysql:host=".$this->dbHost.";dbname=".$this->dbName,
                $this->dbUsername,
                $this->dbPassword,
                $this->options
            );

            //echo"DB connected...";
        }

        catch (PDOException $e){

            echo $e->getMessage();
            exit();
        }
    }

    public function select($sql, $values = null){

        try {

            $stmt = $this->connection->prepare($sql);

            if ($values != null)
                $stmt->execute($values);

            else
                $stmt->execute();

            return $stmt;
        }

        catch (PDOException $e){

            echo "PDOException:".$e->getMessage();
            return false;
        }

    }

    public function insert($table, $fields, $values){

        try {

            $sql = /** @lang Text */
               "INSERT INTO ".$table." (".implode(",", $fields).
               " , created_at) VALUES ( :". implode(", :", $fields)." , now() );";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_combine($fields, $values));

            return true;
        }

        catch (PDOException $e){

            echo $e->getMessage();
            return false;
        }

    }

    public function update($table, $id, $fields, $values){

        $sql ="UPDATE ".$table." SET ";

        foreach (array_combine($fields, $values) as $field=>$value){

            if ($value)
                $sql .= $field ." = ? ,";

            else
                $sql .= $field ." = NULL ,";
        }

        $sql .=" updated_at = now()";
        $sql .=" WHERE id = ?";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_merge(array_filter(array_values($values)), [$id]));

            return true;
        }

        catch (PDOException $e){

            echo $e->getMessage();
            return false;
        }

    }

    public function delete($table, $id){

        $sql = /** @lang Text */ "DELETE FROM ".$table." WHERE id = ? ;";

        try {

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            return true;
        }

        catch (PDOException $e){

            echo $e->getMessage();
            return false;
        }
    }

    public function createTable($sql)
    {
        try{
            $this->connection->exec($sql);
            return true;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }

}