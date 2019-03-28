
<form action="../Controller/login.php?func=login" method="post">
    Login : <input type="text" name="login" />
    <br>
    Password : <input type="password" name="password" />
    <br>
    <?php    if(!empty($_GET["error"])){        echo "<span style=\"color:red;\">A field is invalid ! </span><br>";} ?>
    <br>
    <input type="submit" value="Submit" />
</form>

