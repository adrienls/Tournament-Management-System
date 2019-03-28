<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:42
 */

function connectDB($host, $dbName, $user, $password){
    $dsn = 'mysql:host='.$host.';dbname='.$dbName;
    try {
        $dbConnexion = new PDO($dsn, $user, $password);
        $dbConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnexion;
    }
    catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        return NULL;
    }

}