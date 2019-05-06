<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 02/05/19
 * Time: 21:18
 */

class Database
{
    private $host;
    private $dbName;
    private $connection;
    public function getConnection(){ return $this->connection; }

    //public function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="adrien", $password="password"){
    public function __construct($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword"){
        if($this->connection == NULL){
            $this->host = $host;
            $this->dbName = $dbName;
            $dsn = 'mysql:host='.$host.';dbname='.$dbName;
            try {
                $this->connection = new PDO($dsn, $user, $password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                //$this->connection = NULL;
                die("Failed connection to the the $this->dbName database on host $this->host:"."</br>".$e->getMessage());
            }
        }
    }
    public function __destruct(){ $this->connection = NULL; }
    public function __toString(){
        return "Connection to the $this->dbName database on host $this->host"."</br>";
    }
}