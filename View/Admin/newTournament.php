<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 22/03/2019
 * Time: 14:37
 */
?>
<form action=../../Controller/CRUDTournament.php?func=createTournament method='post'>
    Name of the tournament : <input type='text' name='tournamentName'/>
    <br>
    Number of team in the tournament : <input type='number' step="1" min="0" name='nbTeam'/>
    <br>
    <?php
    if(isset($_GET['error'])){
    if($_GET['error'] == "field_missing_or_nb_invalid") {echo "<br><b style='color:red;'>Fill all the fields !(nb of team > 0)</b><br>";}
    if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Name already used !</b><br>";}
    if($_GET['error'] == "logo_invalid") {echo "<br><b style='color:red;'>Logo is too big !</b><br>";}
    }
    ?>
    <input type='submit' value='Submit'/>
</form>




