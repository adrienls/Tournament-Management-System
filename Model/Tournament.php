<?php
require_once "./Database.php";

class Tournament extends Database
{
    private $id;
    private $name;
    private $nb_team;

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getNbTeam()
    {
        return $this->nb_team;
    }

    function insertTournament($tournamentName, $nbTeam){
        $insertTournament = $this->connection->prepare("INSERT INTO Tournament (id, name, nb_team) VALUES (NULL, :name, :nb_team)");
        $insertTournament->bindParam(':name', $tournamentName);
        $insertTournament->bindParam(':nb_team', $nbTeam);
        $insertTournament->execute();
    }
    function updateTournament($tournament_name, $nb_team, $id){
        $updateTournament = $this->connection->prepare("UPDATE Tournament SET name='$tournament_name', nb_team='$nb_team' WHERE id='$id'");
        $updateTournament->execute();
    }
    function deleteTournament($id){
        $deleteTournament = $this->connection->prepare("DELETE FROM Tournament WHERE id='$id'");
        $deleteTournament->execute();
    }

    public function __toString()
    {
        $description = "Planning table: ".$this."</br>
        id: ".$this->id."</br>
        name: ".$this->name."</br>
        nb_team: ".$this->nb_team."</br>";
        return $description;
    }
}

function getTournamentList(){
    $db = new Database();
    $tournamentList = $db->getConnection()->prepare("SELECT * FROM Tournament ");
    $tournamentList->execute();
    $tournamentList = $tournamentList->fetchAll(PDO::FETCH_CLASS, "Tournament");
    return $tournamentList;
}
function getTournamentById($id){
    $db = new Database();
    $tournamentById = $db->getConnection()->prepare("SELECT * FROM Tournament WHERE id='$id'");
    $tournamentById->execute();
    $tournamentById = $tournamentById->fetch();
    $connection=NULL;
    return $tournamentById;
}
function getNbTeamMax($tournament_id){
    $db = new Database();
    $nbTeamMax = $db->getConnection()->prepare("SELECT nb_team FROM Tournament WHERE id='$tournament_id'");
    $nbTeamMax->execute();
    $nbTeamMax = $nbTeamMax->fetchColumn();
    $connection = NULL;
    return $nbTeamMax;
}