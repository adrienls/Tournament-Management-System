<?php

require_once "../../Controller/controller-Global.php";
require_once "../../Controller/controller-Admin.php";

if(isIdentified()){
    if ($_SESSION['username']=="admin") {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            echo "<h2>Update Admin</h2>
            <form action='../../Controller/controller-Admin.php?func=updateAdmin&id=".$id."' method='post'>";
                echo "Username : <input type='text' name='username' value='".readAdmin($id)."'/><br>
                Password : <input type='password' name='password'/><br>
                Password : <input type='password' name='password_verification'/><br>";
                if(isset($_GET['error'])){
                    if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
                    if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Username already used !</b><br>";}
                    if($_GET['error'] == "password_different") {echo "<br><b style='color:red;'>Fill the same password twice !</b><br>";}
                }
                echo "<br>
                <input type='submit' value='Submit'/>
            </form>
            <a href='view-IndexSuperAdmin.php'>Back</a>";
        }
    }
    else {
        redirect("view-IndexAdmin.php?error=access_denied");
    }
}
else {
    redirect("../index.php?error=access_denied");
}