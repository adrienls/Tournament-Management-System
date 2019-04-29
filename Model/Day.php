<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 01/04/19
 * Time: 13:29
 */

class Day
{
    private $id;
    private $tournament_id;
    private $day_number;
    private $done;

    public function getId(){
        return $this->id;
    }
    public function getTournamentId(){
        return $this->tournament_id;
    }
    public function getDayNumber(){
        return $this->day_number;
    }
    public function getDone(){
        return $this->done;
    }
}