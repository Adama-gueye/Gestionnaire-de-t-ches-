<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Détail de la Tâche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        #header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }

        #task-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .task {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .task h1 {
            font-size: 24px;
            margin: 0 0 10px;
        }

        .task p {
            margin: 0 0 20px;
        }

        .details {
            display: flex;
            justify-content: space-between;
        }

        .priority {
            color: red;
        }
        .dis{
            display: flex;
        }

        .status {
            color: #4CAF50;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn2 {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        a.btn {
            text-decoration: none;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
            
        }

        #header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }
    </style>

<?php
session_start();
if(empty($_SESSION))
    header("location:auth.php");
    include('bd.php');
global $conn;
extract($_POST);

    $id = $_GET['id'];
    $select = "SELECT * FROM tache WHERE idtache = $id";
    $resul = $conn->query($select)->fetch();
   if (isset($_POST['supprime'])) {
    $req = "DELETE FROM tache WHERE idtache = $id";
    $conn->exec($req);
    header('Location: http://localhost/simplon/Atelier13/index.php');
    exit;
}

if (isset($_POST['termine'])) {
    $req = "UPDATE tache SET etat = 'Terminée' WHERE idtache = $id";
    $conn->exec($req);
}

?>

<h2 style="text-align: center;" id="header">Détail de la tache <?=$resul['nomtache']?></h2>
    <div id="task-list">
    <div class="task">
        <form action="" method="post">
        <h1><?=$resul['nomtache'];?></h1>
        <p><?=$resul['description'];?></p>
        <div class="details">
            <div class="priority" style="color: red;">
                Priorité: <?=$resul['priorite'];?>
            </div>
            <div class="status" style="color: #4CAF50;">
                État: <?=$resul['etat'];?>
            </div>
        </div>
        <div class="dis">
        <button type="submit" class="btn" name="termine">Marquer comme terminé</button>
        <button type="submit" name="supprime" class="btn2">Supprimer la tache</button>
        </div>
        
        </form>
    </div>
    <div class="back-button">
            <a href="index.php" class="btn">Retour à la liste des taches</a>
        </div>

        
        
    </div>