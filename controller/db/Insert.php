<?php

require __DIR__ . "./../DbHandler.php";

use Db\DbHandler;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // citanje podataka dobivenih POST metodom
    $name = $_POST['name'];
    $age = $_POST['age'];
    $info = $_POST['info'];
    $wins = $_POST['wins'];
    $loss = $_POST['loss'];

    // određivanje putanje slike gdje ce se spremati
    $target_dir = "../../img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // provjera je li velicina slike manja od 5MB
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // provjera je li $uploadOk postavljen na 0 i da je došlo do error-a
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // ako je sve u redu slika se sprema na server
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $db = new DbHandler();
            $db->insert("INSERT INTO fighters(name, age, info, wins, loss, path) 
                VALUES ('{$name}', '{$age}', '{$info}', '{$wins}', '{$loss}', '{$target_file}')");
    
            header("Location: ../../index.php");
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}