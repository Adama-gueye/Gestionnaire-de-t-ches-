<!DOCTYPE html>
<html>
<head>
    <title>Interface d'Inscription et d'Authentification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ccc;
        }

        #title {
            background-color: #4CAF50;
            color: white;
            padding: 20px 0;
            font-size: 24px;
            margin-bottom: 10px;
            margin-top: 0px;
            text-align: center;
        }

        #forms-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color:white;
            width: 50%;
            margin-left: 25%;
            padding-right: 2%;
        }

        .form {
            border-radius: 10px;
            padding: 20px;
            width: 45%;
            background-color: white;
        }

        .form-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-separator {
            border-right: 3px solid #4CAF50;
            height: 400px;
            margin-left: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            text-align: left;
        }
        #authentification-form{
            margin-top: -14%;
        }
    </style>
</head>
<?php
session_start();
$erreur=[];
$erreur2=[];
include('bd.php');
global $conn;
if (isset($_POST['submit'])) {
    extract($_POST);
    if(empty($auth_email)|| empty($auth_password))
       { $erreur[]= "Tout les champs sont obligatoires";
       }
     elseif(!filter_var($auth_email, FILTER_VALIDATE_EMAIL)) {
        $erreur[]= "Veuillez enregistré un bon mail";
     }else{
        $req = "SELECT * FROM user where email = '$auth_email' and password = '$auth_password'";
        $resul = $conn->query($req)->fetch();
        
        if($resul!=null){
            $_SESSION['id'] = $resul['iduser'];
            $_SESSION['nom'] = $resul['nomuser'];
            header("location:index.php");
        }
        else  $erreur[]= "Login ou Mot de Passe incorrect !";
    }
}
     
if(isset($_POST['inscription'])){
    extract($_POST);
    if(empty($email)|| empty($mdp)|| empty($nom)||empty($confirmation)){
        $erreur2[]= "Tout les champs sont obligatoires";
    }elseif($mdp!==$confirmation){
            $erreur2[]= "le mot de passe n'est pas identique";
       }elseif(strlen($mdp)<8){
            $erreur2[] = "Le mot de passe doit etre supérieur ou egal a 8 caractéres";
       }
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur2[] = "L'adresse e-mail n'est pas valide.";
    }elseif((!(preg_match('/[a-zA-Zéè]$/', $nom)))|| strlen($nom)<5){
        $erreur2[]= "Une erreur s'est produite sur la saisie de votre nom ou de votre prénom";
    }
    else{
        try {
            $req = "INSERT INTO user(iduser,nomuser,email,password) VALUES (NULL,'$nom','$email','$mdp')";
            $resul = $conn->exec($req);
            echo "<h3 style='text-align : center; color : green'>Votre compte a été creer avec succes</h3>";
        } catch (PDOException $e) {
            $erreur2[]= "Ce mail existe déja";
        }
       
    }
}

echo "<h3 style='text-align : center; color : red'>".implode(". ",$erreur)."</h3>";
echo "<h3 style='text-align : center; color : red'>".implode(". ",$erreur2)."</h3>";
?>

<body>
    <h1 id="title">Création de Compte & Connexion</h1>
    <div id="forms-container">
        <div class="form" id="inscription-form">
            <h2>Créer un Compte</h2>
            <form method="post">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" <?php if($erreur2!=[]){?> value="<?=$_POST["nom"]?>"<?php }?>>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" <?php if($erreur2!=[]){?> value="<?=$_POST["email"]?>"<?php }?>>
                <label for="password">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" <?php if($erreur2!=[]){?> value="<?=$_POST["mdp"]?>"<?php }?>>
                <label for="confirmation">Confirmation:</label>
                <input type="password" id="confirmation" name="confirmation" <?php if($erreur2!=[]){?> value="<?=$_POST["confirmation"]?>"<?php }?>>
                <button class="form-button" type="submit" name="inscription">S'inscrire</button>
            </form>
        </div>

        <div class="form-separator"></div>

        <div class="form" id="authentification-form">
            <h2>Authentification</h2>
            <form method="post">
                <label for="auth-email">Email:</label>
                <input type="email" id="auth-email" name="auth_email" <?php if($erreur!=[]){?> value="<?=$_POST["auth_email"]?>"<?php }?>>
                <label for="auth-password">Mot de passe:</label>
                <input type="password" id="auth-password" name="auth_password" <?php if($erreur!=[]){?> value="<?=$_POST["auth_password"]?>"<?php }?>>
                <button class="form-button" type="submit" name="submit">S'authentifier</button>
            </form>
        </div>
    </div>
</body>
</html>
