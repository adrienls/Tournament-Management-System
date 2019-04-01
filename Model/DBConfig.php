<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:52
 */

class DBConfig{
    private $host;
    private $dbName;
    private $user;
    private $password;
    private $dbConnection = NULL;

    public function __construct($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword") {
    //public function __construct($host="localhost", $dbName="Tournament-Management-System", $user="adrien", $password="password") {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
        $this->connectDB();
    }
    public function getHost() {return $this->host;}
    public function setHost($host) {$this->host = $host;}
    public function getDBName() {return $this->dbName;}
    public function setDBName($dbName) {$this->dbName = $dbName;}
    public function getUser() {return $this->user;}
    public function setUser($user) {$this->user = $user;}
    public function getPassword() {return $this->password;}
    public function setPassword($password) {$this->password = $password;}
    public function getDBConnection() {return $this->dbConnection;}
    public function setDBConnection($dbConnection) {$this->dbConnection = $dbConnection;}

    public function connectDB(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName;
        try {
            $this->dbConnection = new PDO($dsn, $this->user, $this->password);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
}