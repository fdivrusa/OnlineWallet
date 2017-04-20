<?php
include("header.php");

if (!$_SESSION['userRight'] >= 1) {

    if (isset($_POST['Email']) && isset($_POST['UserName']) && isset($_POST['FirstName']) && isset($_POST['Pwd']) && isset($_POST['PwdVerif'])) {
        include_once("DB.php");

        try {
            $mdp1 = sha1($_POST['Pwd']);
            $userRight = 1; //Les droits des utilisateurs normaux est 1, je mettrais 2 pour enregistrer l'admin (moi)
            $bd = new PDO('mysql:host=' . $hote . ';dbname=' . $nomDB, $user, $mdp);
            $req = $bd->prepare('INSERT INTO users VALUE (:Email,:UserName,:FirstName,:Pwd,:UserRight)');
            $req->execute(array('Email' => $_POST['Email'], 'UserName' => $_POST['UserName'], 'FirstName' => $_POST['FirstName'],'Pwd' => $mdp1, 'UserRight' => $userRight));


        } catch (Exception $e) {

            echo 'An error has occured'.$e;
        }

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