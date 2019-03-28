<?php

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}
if(isset($_GET['func'])){
    echo "Yes! C'est bon! <br>";
    $_GET['func']();
}

