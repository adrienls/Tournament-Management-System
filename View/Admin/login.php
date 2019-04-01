
<form action="../../Controller/Login.php?func=login" method="post">
    <h2>Connection</h2>
    Login : <input type="text" name="login" />
    <br>
    Password : <input type="password" name="password" />
    <br>
    <?php   if(isset($_GET['error'])){echo "<br><b style='color:red;'>A field is invalid !</b><br>";}   ?>
    <br>
    <input type="submit" value="Submit" />
</form>

