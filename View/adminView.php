<?php
//include "controller.php";

session_start();

if(isset($_SESSION['username'])){
    echo "Welcome ".$_SESSION['username'];
}
else{
    session_destroy();
    header('Location: index.php?error=bad_login');
}
echo "<br>Your options are :";

?>
<br>
<a href="newTournament.php">Add tournament</a>
<br>
<a href="../Controller/login.php?func=logout">Disconnect</a>


<?php
/*
    if(!empty($_GET["ajout"])){        echo "<br><span style=\"color:green;\">Ajout bien validé! </span><br>";}
    if(!empty($_GET["delete"])){        echo "<br><span style=\"color:green;\">Suppression validé! </span><br>";}
    if(!empty($_GET["modif"])){        echo "<br><span style=\"color:green;\">Changement validé! </span><br>";}
    */
?>
