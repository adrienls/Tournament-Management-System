<?php
echo "<h1> TP n°3 PHP : chaînes et tableaux </h1>";

echo "<h2> I. les chaînes </h2>";

echo "<br>QUESTION 1:   ";
$identite = array('alain', 'basile', 'David', 'Edgar');
$age = array(1, 15, 35, 65);
$mail = array('moi.meme@gtail.be', 'truc@bruce.zo', 'caro@caramel.org', 'trop@monmel.fr');
function extraction($rand, &$domaine, &$extension, $mail){
    $ddomaine = strpos($mail[$rand], '@');
    $chaine=substr($mail[$rand],$ddomaine+1);
    $fdomaine = strpos($chaine, '.');
    $extension=substr($chaine,$fdomaine+1);
    $taille_d=strlen($chaine);
    $taille_e=strlen($extension);
    $domaine=substr($chaine,0,$taille_d-$taille_e-1);
}
function aleatoire(&$identite, &$age, &$mail)
{
    $rand = array_rand($identite, 1);
//    echo "$identite[$rand]<br>$age[$rand]<br>$mail[$rand]";
    extraction($rand, $domaine, $extension, $mail);
    echo "<br>je me nomme $identite[$rand] j'ai $age[$rand] ans et mon mail est $mail[$rand] du domaine $domaine avec
l'extension $extension";
}

aleatoire($identite, $age, $mail);

echo "<br>QUESTION 2:   ";
function aleatoire2(&$identite, &$age, &$mail)
{
    $rand = array_rand($identite, 1);
//    echo "$identite[$rand]<br>$age[$rand]<br>$mail[$rand]";

    extraction($rand, $domaine, $extension, $mail);
    $nom=substr($identite[$rand],0,1);
    $NOM1=strtoupper($nom);
    $NOM2=substr($identite[$rand],1);
    $NOM=$NOM1.$NOM2;
    echo "<br>Je me nomme $NOM j'ai $age[$rand] an";
    if ($age[$rand]>1){echo "s";}
    echo " et mon mail est $mail[$rand] du domaine $domaine avec l'extension $extension";
}
aleatoire2($identite, $age, $mail);

echo "<br>QUESTION 3:   <br>";
$array=array("Daniel","Amandine","daniel","Zoé","Zoé","Tristan","véronique");
//var_dump($array);
sort ($array,SORT_NATURAL |SORT_FLAG_CASE);
//var_dump($array);
foreach ($array as $value){
    echo "$value<br>";
}
echo "<br>QUESTION 4:   <br>";

//for($i=0; $i<count($array);$i++) {    $array[$i]=strtolower($array[$i]);}
foreach ($array as $i => $value) {
    $array[$i]=strtolower($value);
}
$compt = array_count_values($array);
foreach ($compt as $key => $value){
    echo " Il y a $value fois $key<br>";
}

echo "<br>QUESTION 5:   <br>";

$people = array(
    array("nom"=>"Daniel", "age"=>18, "statut"=>"étudiant"),
    array("nom"=>"Amandine","age"=>22, "statut"=>"étudiant"),
    array("nom"=>"Zoé", "age"=>55, "statut"=>"prof"),
    array("nom"=>"Georges", "age"=>35, "statut"=>"banquier")
);
$age  = array_column($people, 'age');
$nom = array_column($people, 'nom');
$statut = array_column($people, 'statut');
array_multisort($age, SORT_ASC, $people);
var_dump($people);

echo "<br>QUESTION 6:   <br>";

$ser = serialize($array);
$unser = unserialize($ser);

echo "Tableau après serialize : ".$ser."<br>";
echo "Tableau apres unserialize : ";
var_dump($unser);
