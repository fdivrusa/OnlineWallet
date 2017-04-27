<?php

include("header.php");
include_once ("DBConnect.php");
include_once ("User.php");

//Vérification du droit de l'utilisateur
if (!$_SESSION['userRight'] >= 1) {

    //On vérifie que l'utilisateur a bien remplis tout les champs
    if (!empty($_POST['Email']) && !empty($_POST['UserName']) && !empty($_POST['FirstName']) && !empty($_POST['Pwd']) && !empty($_POST['PwdVerif'])) {

        //Connexion à la BDD
        $dbConnect = new DBConnect();
        $newUser = new User($dbConnect);

        //Construction de l'objet user
        $newUser->addUser($_POST['Email'],$_POST['UserName'], $_POST['FirstName'], $_POST['Pwd'], 1);

    } else {

        ?>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="description" content="Inscription à OnlineWallet">
            <meta name="keywords"
                  content="Banque en ligne, argent, Wallet, argent en ligne, portefeuille en ligne, portefeuille, EWallet, OnlineWallet, OnlineBank">
            <meta name="robots" content="index, follow">
            <meta name="geo.placename" content="Manage, Hainaut">
            <meta name="geo.region" content="BE-WHT">
            <meta name="author" lang="fr" content="Florian Di Vrusa">
            <meta name="generator" content="Intellij IDEA 2017.1">
            <title>Connexion</title>
            <link rel="stylesheet" type="text/css" href="../CSS/StyleInscription.css">
        </head>

        <body>

        <form method="POST" action="Inscription.php">
            <div id="Inscription">
                <h3>Inscription</h3>
                <input class="champ" type="text" name="Email" placeholder="Email" value=""><br>
                <input class="champ" type="text" name="UserName" placeholder="Name"><br>
                <input class="champ" type="text" name="FirstName" placeholder="Firstname"><br>
                <input class="champ" type="password" name="Pwd" placeholder="Password"><br>
                <input class="champ" type="password" name="PwdVerif" placeholder="Password verification"><br>
                <input id="bouton" type="submit" value="Create an account" title="Create an account">
                <div id="login">
                    <p><a href="../PHP/Login.php">Login</a></p>
                </div>
            </div>
        </form>

        </body>
        </html>


        <?php
    }
} else {

    echo("vous etes logué");

}

?>