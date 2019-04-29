<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:41
 */

class Tournament{
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
}