<?php

function redirect($link) {
    header("Location: ".$link);
    exit();
}

function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword"){
//function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="adrien", $password="password"){
    $dsn = 'mysql:host='.$host.';dbname='.$dbName;
    try {
        $dbConnection = new PDO($dsn, $user, $password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
    catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        return NULL;
    }
}