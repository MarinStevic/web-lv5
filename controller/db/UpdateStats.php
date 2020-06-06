<?php

require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // citanje podataka dobivenih POST metodom
    $winId = $_POST['winId'];
    $lossId = $_POST['lossId'];

    $db = new DbHandler();

    // kada se dobije id pobjednika i gubtnika prvo se iscitavaju trenutne vrijednosti i potom se povecavaju za 1 i zapisuju natrag u bazu

    $winner = $db->select("SELECT * FROM fighters WHERE id = '{$winId}'");
    $wins = $winner->fetch_assoc();
    $temp = $wins["wins"]+1;

    $db->update("UPDATE fighters SET wins = '{$temp}' 
                WHERE id = $winId");

    $loser = $db->select("SELECT * FROM fighters WHERE id = '{$lossId}'");
    $loss = $loser->fetch_assoc();
    $temp = $loss["loss"]+1;

    $db->update("UPDATE fighters SET loss = '{$temp}' 
                WHERE id = $lossId");
}