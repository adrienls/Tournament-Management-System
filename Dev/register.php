<?php
require_once "../Controller/GlobalFunctions.php";

session_start();

echo "<h2>New Admin</h2>
    <form action=\"../Controller/CRUDAdmin.php?func=createAdmin\" method='post'>
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