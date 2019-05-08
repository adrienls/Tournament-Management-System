<?php
require_once "Database.php";

class Day
{
    private $id;
    private $tournament_id;
    private $day_number;
    private $done;

    public function getId(){ return $this->id; }
    public function getTournamentId(){ return $this->tournament_id; }
    public function getDayNumber(){ return $this->day_number; }
    public function getDone(){ return $this->done; }

    public function insertDay($tournament_id, $day_number) {
        $db = new Database();
        $insertDay = $db->getConnection()->prepare("INSERT INTO Day (id, tournament_id, day_number, done) VALUES (NULL, :tournament_id, :day_number, 0)");
        $insertDay->bindParam(':tournament_id', $tournament_id);
        $insertDay->bindParam(':day_number', $day_number);
        $insertDay->execute();
    }
    public function deleteDay($id) {
        $db = new Database();
        $deleteDay = $db->getConnection()->prepare("DELETE FROM Day WHERE id='$id'");
        $deleteDay->execute();
    }
    public function updateDayPlayed($id) {
        $db = new Database();
        $update = $db->getConnection()->prepare("UPDATE Day SET done=1 WHERE id='$id'");
        $update->execute();
    }

    public function __toString() {
        $description = "Day table: ".$this."</br>
        id: ".$this->id."</br>
        tournament_id: ".$this->tournament_id."</br>
        day_number: ".$this->day_number."</br>
        done: ".$this->done."</br>";
        return $description;
    }
}

function getDayList($tournament_id) {
    $db = new Database();
    $dayList = $db->getConnection()->prepare("SELECT * FROM Day WHERE tournament_id='$tournament_id'");
    $dayList->execute();
    $dayList = $dayList->fetchAll(PDO::FETCH_CLASS, "Day");
    return $dayList;
}
function getDayById($id){
    $db = new Database();
    $dayById = $db->getConnection()->prepare("SELECT * FROM Day WHERE id='$id'");
    $dayById->execute();
    $dayById = $dayById->fetchObject("Day");
    return $dayById;
}
function getNbPlayedDays($tournament_id) {
    $db = new Database();
    $nbPlayedDays = $db->getConnection()->prepare("SELECT COUNT(id) FROM Day WHERE tournament_id='$tournament_id' AND done=1");
    $nbPlayedDays->execute();
    $nbPlayedDays = $nbPlayedDays->fetchColumn();
    return $nbPlayedDays;
}
