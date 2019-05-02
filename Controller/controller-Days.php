<?php

function generateDays($tournament_id) {
    require_once "../Model/Database.php";

    $teams = dbGetTeamList($tournament_id);

    $nbDays = count($teams);
    if ($nbDays % 2 == 0) {
        $nbDays--;
    }

    // Days creation
    for ($i = 1; $i <= $nbDays; $i++) {
        dbInsertDay($tournament_id,$i);
    }

    $days = dbGetDayList($tournament_id);
    /*foreach ($days as $day) {
        if($day['day_number'] != 1) {
            //
        }
        //Generate Matches
        $matches =

        //Insert Matches
        insertPlanning($day['day_id'], $teams[0]['name'], $teams[1]['id']);
    }*/
}