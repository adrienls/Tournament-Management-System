<?php
require_once "Database.php";

class Planning
{
    private $id;
    private $day_id;
    private $teamA_name;
    private $teamB_name;
    private $teamA_nbGoal;
    private $teamB_nbGoal;

    public function getId()
    {
        return $this->id;
    }
    public function getDayId()
    {
        return $this->day_id;
    }
    public function getTeamAName()
    {
        return $this->teamA_name;
    }
    public function getTeamBName()
    {
        return $this->teamB_name;
    }
    public function getTeamANbGoal()
    {
        return $this->teamA_nbGoal;
    }
    public function getTeamBNbGoal()
    {
        return $this->teamB_nbGoal;
    }

    public function insertPlanning($day_id, $teamA_name, $teamB_name) {
        $db = new Database();
        $insertPlanning = $db->getConnection()->prepare("INSERT INTO Planning (id, day_id, teamA_name, teamB_name, teamA_nbGoal, teamB_nbGoal) VALUES (NULL, :day_id, :teamA_name, :teamB_name, NULL, NULL)");
        $insertPlanning->bindParam(':day_id', $day_id);
        $insertPlanning->bindParam(':teamA_name', $teamA_name);
        $insertPlanning->bindParam(':teamB_name', $teamB_name);
        $insertPlanning->execute();
    }
    public function deletePlanning($id) {
        $db = new Database();
        $deletePlanning = $db->getConnection()->prepare("DELETE FROM Planning WHERE id='$id'");
        $deletePlanning->execute();
    }
    public function updateMatchGoal($id, $teamA_nbGoal, $teamB_nbGoal) {
        $db = new Database();
        $update = $db->getConnection()->prepare("UPDATE Planning SET teamA_nbGoal=$teamA_nbGoal,teamB_nbGoal=$teamB_nbGoal WHERE id='$id'");
        $update->execute();
    }

    public function __toString()
    {
        $description = "Planning table: ".$this."</br>
        id: ".$this->id."</br>
        day_id: ".$this->day_id."</br>
        teamA_name: ".$this->teamA_name."</br>
        teamB_name: ".$this->teamB_name."</br>
        teamA_nbGoal: ".$this->teamA_nbGoal."</br>
        teamB_nbGoal: ".$this->teamB_nbGoal."</br>";
        return $description;
    }
}

function getDayPlanning($id) {
    $db = new Database();
    $dayPlanning = $db->getConnection()->prepare("SELECT * FROM Day JOIN Planning ON Day.id = Planning.day_id WHERE tournament_id='$id'");
    $dayPlanning->execute();
    $dayPlanning = $dayPlanning->fetchAll();
    //return the info as an array not a class, because it is joined tables
    return $dayPlanning;
}
function getMatchesList($day_id) {
    $db = new Database();
    $matches = $db->getConnection()->prepare("SELECT * FROM Planning WHERE day_id='$day_id'");
    $matches->execute();
    $matchesList = $matches->fetchAll(PDO::FETCH_CLASS, "Planning");
    return $matchesList;
}
function getMatchOfTeam($name){
    $db = new Database();
    $matches = $db->getConnection()->prepare("SELECT * FROM Planning WHERE teamA_name='$name' OR teamB_name='$name' AND teamA_nbGoal!='NULL'");
    $matches-> execute();
    $matchesList = $matches->fetchAll(PDO::FETCH_CLASS, "Planning");
    return $matchesList;
}