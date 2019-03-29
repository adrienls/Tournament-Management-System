<?php

function redirect($link) {
    header("Location: ".$link);
    exit();
}

function connection(){
    session_start();
    if (isset($_SESSION['dbConnection'])){
        return $connection = $_SESSION['dbConnection']->getDBConnection();
    }
    else{
        redirect("../View/Admin/newTeam.php?error=session_unavailable");
    }
}
