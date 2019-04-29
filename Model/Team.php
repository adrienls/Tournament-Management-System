<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:40
 */

class Team{
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
}