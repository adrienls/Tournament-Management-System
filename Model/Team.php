<?php
require_once "./Database.php";

class Team extends Database
{
    private $id;
    private $name;
    private $tournament_id;
    private $nb_visit;
    private $path_logo;

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getTournamentId()
    {
        return $this->tournament_id;
    }
    public function getNbVisit()
    {
        return $this->nb_visit;
    }
    public function getPathLogo()
    {
        return $this->path_logo;
    }

    function insertTeam($name, $tournament_id, $fileDestination){
        $insertTeam = $this->connection->prepare("INSERT INTO Team (id, name, tournament_id, nb_visit, path_logo) VALUES (NULL, :name, :tournament_id, 0, :path_logo)");
        $insertTeam->bindParam(':name', $name);
        $insertTeam->bindParam(':tournament_id', $tournament_id);
        $insertTeam->bindParam(':path_logo', $fileDestination);
        $insertTeam->execute();
    }
    function updateTeam($team_name, $fileDestination, $id_team){
        $updateTeam = $this->connection->prepare("UPDATE Team SET name='$team_name', path_logo='$fileDestination' WHERE id='$id_team'");
        $updateTeam->execute();
    }
    function deleteTeam($team_id){
        $deleteTeam = $this->connection->prepare("DELETE FROM Team WHERE id='$team_id'");
        $deleteTeam->execute();
    }

    public function __toString(){
        $description = "Team table: ".$this."</br>
        id: ".$this->id."</br>
        name: ".$this->name."</br>
        tournament_id: ".$this->tournament_id."</br>
        nb_visit: ".$this->nb_visit."</br>
        path_logo: ".$this->path_logo."</br>";
        return $description;
    }
}

function getTeamList($id){
    $db = new Database();
    $teamList = $db->getConnection()->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $teamList->execute();
    $teamList = $teamList->fetchAll(PDO::FETCH_CLASS, "Team");
    return $teamList;
}
function getNbTeam($tournament_id){
    $db = new Database();
    $nbTeam = $db->getConnection()->prepare("SELECT COUNT(id) FROM Team WHERE tournament_id='$tournament_id'");
    $nbTeam->execute();
    return $nbTeam;
}
function getTeamById($id_team){
    $db = new Database();
    $teamById = $db->getConnection()->prepare("SELECT * FROM Team WHERE id='$id_team'");
    $teamById->execute();
    $teamById = $teamById->fetchObject();
    return $teamById;
}
function getInfoTeam($team_id){
    $db = new Database();
    $infoTeam = $db->getConnection()->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $infoTeam->execute();
    $infoTeam= $infoTeam->fetchObject();
    return $infoTeam;
}