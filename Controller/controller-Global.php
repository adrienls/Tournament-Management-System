<?php

function redirect($link) {
    header("Location: ".$link);
    exit();
}

function isIdentified() {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return (isset($_SESSION['username']));
}

