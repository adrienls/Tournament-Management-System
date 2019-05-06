<?php

require_once "../../Controller/controller-Global.php";
require_once "../../Controller/controller-Admin.php";

session_start();

if(isset($_SESSION['username'])){
    if ($_SESSION['username']=="admin") {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            echo "<h2>Update Admin</h2>
            <form action='../../Controller/controller-Admin.php?func=updateAdmin&id=".$id."' method='post'>";
                echo "Username : <input type='text' name='username' value='".readAdmin($id)."'/><br>
                Password : <input type='password' name='password'/><br>";
                if(isset($_GET['error'])){
                    if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
                }
                echo "<br>
                <input type='submit' value='Submit'/>
            </form>";
        }
    }
    else {
        redirect("view-IndexAdmin.php?error=access_denied");
    }
}
else {
    redirect("../index.php?error=access_denied");
}