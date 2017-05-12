<?php

include("Header.php");
require_once("../../Class/DBConnect.php");
require_once("../../Class/OperationUser.php");

//On regarde si l'utilisateur n'est pas déja logué, sinon on le redirige vers sa page
if (!$_SESSION['UserRight'] >= 1) {

    //On vérifie que l'utilisateur a bien remplis tout les champs
    if (!empty($_POST['Email']) && !empty($_POST['UserName']) && !empty($_POST['FirstName']) && !empty($_POST['Pwd']) && !empty($_POST['PwdVerif']) &&
        isset($_POST['Email']) && isset($_POST['UserName']) && isset($_POST['FirstName']) && isset($_POST['Pwd']) && isset($_POST['PwdVerif'])
    ) {

        //Je donne les valeurs de mes champs à des variables (facilite les vérifications)
        $userName = $_POST['UserName'];
        $userMail = $_POST['Email'];
        $userFirstName = $_POST['FirstName'];
        $pwd = $_POST['Pwd'];
        $pwdVerif = $_POST['PwdVerif'];
        $userRight = 1;

        $dbConnect = new DBConnect();

        //Opération d'ajout
        $operationAdd = new OperationUser($dbConnect);

        //Vérification de l'adresse mail (Valide et pas déja dans la BDD)
        if ($operationAdd->verifMailNotInDB($userMail)) {

            //Vérification du mdp (assez long et correspondant) ==> MDP SENSIBLE A LA CASSE
            if ($operationAdd->verifPasswordInscription($pwd, $pwdVerif)) {

                //Ajout de l'utilisateur
                $operationAdd->addUser($userMail, $userName, $userFirstName, $pwd, $userRight);

            } else {

                //Sinon on affiche une erreur lors de la redirection
                $_SESSION['Error'] = "Make sure that you wrote correctly your password in the verification";
                $operationAdd->redirect("Inscription.php");
            }

        } else {

            $_SESSION['Error'] = "You have to enter a valid Email address ! Make sure that you are not already registered";
            $operationAdd->redirect("Inscription.php");
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
            <meta name="author" lang="en" content="Florian Di Vrusa">
            <meta name="generator" content="Intellij IDEA 2017.1">
            <title>Inscription</title>
            <link rel="stylesheet" type="text/css" href="../../../CSS/StyleInscription.css">
        </head>

        <body>

        <form method="POST" action="Inscription.php">

            <div id="Inscription">

                <h3>Inscription</h3>

                <h5><?php
                    //On regarde si il y a des erreurs que l'utilisateur à pu faire et on les effaces car elles sont affichées dans le formulaire lors de la redirection
                    if (isset($_SESSION['Error'])) {
                        $error = $_SESSION['Error'];
                        echo $error;
                        unset($_SESSION['Error']);
                    }; ?></h5>

                <input class="champ" type="text" name="Email" placeholder="Email" value=""><br>

                <input pattern="[A-Za-z -]{2,}" title="Only valid name" class="champ" type="text" name="UserName"
                       placeholder="Name"><br>

                <input pattern="[A-Za-z -]{2,}" title="Only valid firstname" class="champ" type="text" name="FirstName"
                       placeholder="Firstname"><br>

                <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       title="Enter password with at least 8 characters, 1 UPPERCASE letter, 1 lowercase and 1 number"
                       class="champ" type="password" name="Pwd" placeholder="Password"><br>

                <input class="champ" type="password" name="PwdVerif" placeholder="Password verification"><br>

                <input id="button" type="submit" value="Create an account" title="Create an account">

                <div id="login">

                    <p><a href="Login.php">Login</a></p>

                </div>

            </div>

        </form>

        </body>
        </html>

        <?php
    }
} else {

    header("Location: ../UserPages/Home.php");
}

?>