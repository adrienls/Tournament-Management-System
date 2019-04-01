<?php
//include "controller.php";
require_once "../../Controller/CRUDAdmin.php";
session_start();

if(!isset($_SESSION['username'])){
    session_destroy();
    header('Location: ../index.php?error=bad_login');
    exit();
}

// test le superAdmin!!
  elseif($_SESSION['username']==="admin"){
      echo "<a href=\"superAdmin.php\">Admin management page </a>";
}

else{
    echo "Welcome ".$_SESSION['username'].";<br><br>";
}
viewTournament();
echo "<br><br>Your options are :";


?>
<br>
<a href="newTournament.php">Add tournament</a>
<br>
<a href="../../Controller/Login.php?func=logout">Disconnect</a>


<?php

    if(!empty($_GET["ajout"])){        echo "<br><span style=\"color:green;\">Ajout bien validé! </span><br>";}
    if(!empty($_GET["delete"])){        echo "<br><span style=\"color:green;\">Suppression validé! </span><br>";}
    if(!empty($_GET["modif"])){        echo "<br><span style=\"color:green;\">Changement validé! </span><br>";}



?>
