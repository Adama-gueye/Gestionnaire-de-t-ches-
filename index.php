<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    <title>Gestionnaire de Tâches</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        #header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }

        #task-form {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 50%;
            margin: 20px auto;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        }

        .task h3 {
            margin: 0;
            font-size: 20px;
        }

        .task p {
            margin: 0;
        }
    </style>
</head>
<?php
session_start();
if(empty($_SESSION))
    header("location:auth.php");
if (isset($_GET['deconnexion'])) {
    session_unset();
    header("location:auth.php");
}
?>


<div>
    <?php
    $erreur = [];
    include('bd.php');
    global $conn;
    $id = $_SESSION['id'];

    $select = "SELECT * FROM tache WHERE iduser = $id";
    $resuls = $conn->query($select)->fetchAll();
        if (isset($_POST['submit'])) {
            extract($_POST);
            if(empty($nom)||empty($desc)||empty($priorite)||empty($etat)){
                $erreur[] = "Tous les champs sont obligatoires";
            } else{
                $req = ("INSERT INTO `tache` (`idtache`, `nomtache`, `description`, `echeance`, `priorite`, `etat`, `iduser`) VALUES (NULL, '$nom', '$desc', '$echeance', '$priorite', '$etat', $id)");
                $resul = $conn->exec($req);
                if($resul)
                echo "Tache enregistrer avec succes";

            }
            
        }
echo "<h3 style='text-align : center; color : red'>".implode(". ",$erreur)."</h3>";   
        
?>
    <a href="?deconnexion" style="color: danger;">Se déconnecter</a>
</div>

<body>
    <h2 id="header">Gestionnaire de Tâches <br> <?=$_SESSION['nom']?></h2>

    <div id="task-form">
        <h2>Ajouter une Nouvelle Tâche</h2>
        <form method="post">
            <label for="nom" class="form-label">Nom de la Tâche:</label>
            <input type="text" id="nom" name="nom" class="form-input">

            <label for="desc" class="form-label">Description:</label>
            <textarea id="desc" name="desc" class="form-input" <?php if($erreur!=[]){?> value="<?=$_POST["desc"]?>"<?php }?>></textarea>

            <label for="echeance" class="form-label">Date d'Échéance:</label>
            <input type="date" id="echeance" name="echeance" class="form-input" <?php if($erreur!=[]){?> value="<?=$_POST["echeance"]?>"<?php }?>>

            <label for="priorite" class="form-label">Priorité:</label>
            <select id="priorite" name="priorite" class="form-input" <?php if($erreur!=[]){?> value="<?=$_POST["priorite"]?>"<?php }?>>
                <option value="Faible">Faible</option>
                <option value="Moyenne">Moyenne</option>
                <option value="Elevée">Élevée</option>
            </select>

            <label for="etat" class="form-label">État:</label>
            <select id="etat" name="etat" class="form-input" <?php if($erreur!=[]){?> value="<?=$_POST["etat"]?>"<?php }?>>
                <option value="A faire">À Faire</option>
                <option value="En cour">En Cours</option>
                <option value="Terminée">Terminée</option>
            </select>
            <button type="submit" class="form-button" name="submit">Créer la Tâche</button>
        </form>
    </div>

    <h2 style="text-align: center;">Liste des Tâches</h2>
    <div id="task-list">
    <?php foreach ($resuls as $value) { ?>
    <div class="task">
        <h1><?=$value['nomtache'];?></h1>
        <p><?=$value['description'];?></p>
        <div class="details">
            <div class="priority" style="color: red;">
                Priorité: <?=$value['priorite'];?>
            </div>
            <div class="status" style="color: #4CAF50;">
                État: <?=$value['etat'];?>
            </div>
        </div>
        <a href="detail.php?id=<?=$value['idtache']?>" class="btn btn-primary">Détail</a>
    </div>
<?php } ?>

        
        
    </div>
</body>
</html>
