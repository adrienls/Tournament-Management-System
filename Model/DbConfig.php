<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:52
 */

class DbConfig{
    private $host;
    private $dbName;
    private $user;
    private $password;
    private $dbConnexion = NULL;

    public function __construct($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword") {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
    }
    public function getHost() {return $this->host;}
    public function setHost($host) {$this->host = $host;}
    public function getDbName() {return $this->dbName;}
    public function setDbName($dbName) {$this->dbName = $dbName;}
    public function getUser() {return $this->user;}
    public function setUser($user) {$this->user = $user;}
    public function getPassword() {return $this->password;}
    public function setPassword($password) {$this->password = $password;}
    public function getDbConnexion() {return $this->dbConnexion;}
    public function setDbConnexion($dbConnexion) {$this->dbConnexion = $dbConnexion;}

    public function connectDB(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName;
        try {
            $this->dbConnexion = new PDO($dsn, $this->user, $this->password);
            $this->dbConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
}