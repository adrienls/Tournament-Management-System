<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 01/04/19
 * Time: 13:29
 */

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
}