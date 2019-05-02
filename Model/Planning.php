<?php
require_once "./Database.php";

class Planning extends Database
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

    function insertPlanning($day_id, $teamA_id, $teamB_id) {
        $insertPlanning = $this->connection->prepare("INSERT INTO Planning (id, day_id, teamA_name, teamB_name, teamA_nbGoal, teamB_nbGoal) VALUES (NULL, :day_id, :teamA_name, :teamB_name, NULL, NULL)");
        $insertPlanning->bindParam(':day_id', $day_id);
        $insertPlanning->bindParam(':teamA_id', $teamA_id);
        $insertPlanning->bindParam(':teamB_id', $teamB_id);
        $insertPlanning->execute();
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