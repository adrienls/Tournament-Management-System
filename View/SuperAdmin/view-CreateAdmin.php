<?php

require_once "../../Controller/controller-GlobalFunctions.php";

session_start();

if(isset($_SESSION['username'])){
    if ($_SESSION['username']=="admin") {
        echo "<form action='../../Controller/controller-CRUDAdmin.php?func=createAdmin' method='post'>
            Username : <input type='text' name='username'/>
            <br>
            Password : <input type='password' name='password'/>
            <br>";
            if(isset($_GET['error'])){
                if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
                if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Username already used !</b><br>";}
            }
            echo "
            <br>
            <input type='submit' value='Submit'/>
        </form>";
    }
    else {
        redirect("view-IndexAdmin.php?error=access_denied");
    }
}
else {
    redirect("../index.php?error=access_denied");
}