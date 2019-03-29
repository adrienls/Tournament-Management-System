<?php

require_once "../../Controller/redirect.php";

session_start();

if(isset($_SESSION['username'])){
    if ($_SESSION['username']=="admin") {
        echo "
        <h2>New Admin</h2>
        <form action=\"../../Controller/newAdmin.php?func=newAdmin\" method='post'>
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
        redirect("adminView.php");
    }
}
else {
    redirect("../index.php");
}