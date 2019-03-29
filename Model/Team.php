<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 22/03/19
 * Time: 16:40
 */

class Team{
    private $name;
    private $logoPath;
    private $nbVisit;

    public function __construct($name, $logoPath) {
        $this->name = $name;
        $this->logoPath = $logoPath;
    }
    public function getName() {return $this->name;}
    public function setName($name) {$this->name = $name;}
    public function getLogoPath() {return $this->logoPath;}
    public function setLogoPath($logoPath) {$this->logoPath = $logoPath;}
    public function getNbVisit() {return $this->nbVisit;}
    public function setNbVisit($nbVisit) {$this->nbVisit = $nbVisit;}
}