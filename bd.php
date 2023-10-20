<?php
    const SERVEUR="localhost"; 
    const BD="gestionnaire"; 
    const USER="root"; 
    const MDP=""; 
    $bdcon='mysql:host='.SERVEUR.';dbname='.BD.';charset=utf8';
    $option=array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
    try {
        $conn=new PDO($bdcon,USER,MDP,$option);
    } catch (PDOException $th) {
        die("Erreur de connexion :".$th->getMessage());
    }
?>