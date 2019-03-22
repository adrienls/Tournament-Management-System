<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:41
 */

class Tournament{
    private $listTeams;
    private $name;

    public function __construct($listTeams, $name) {
        $this->listTeams = $listTeams;
        $this->name = $name;
    }
    public function getListTeams() {return $this->listTeams;}
    public function setListTeams($listTeams) {$this->listTeams = $listTeams;}
    public function getName() {return $this->name;}
    public function setName($name) {$this->name = $name;}
}