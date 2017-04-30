<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 01-04-17
 * Time: 16:21
 */

include("Header.php");
require_once("../Class/DBConnect.php");
require_once ("../Class/Operation.php");


//Si l'utilisateur est déja logué, on le redirige vers sa page
if (!$_SESSION['userRight'] >= 1) {

    if (isset($_POST['Email']) && isset($_POST['Pwd']) && !empty($_POST['Email']) && !empty($_POST['Pwd'])) {

        //Connexion à la BDD
        $dbConnect = new DBConnect();

        //Operation de Log
        $operationLog = new Operation($dbConnect);

        //Si l'adresse est valide et que elle est dans la DB
        if($operationLog->verifMail($_POST['Email'])) {


        }
    }

    ?>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Connexion à OnlineWallet">
        <meta name="keywords"
              content="Banque en ligne, argent, Wallet, argent en ligne, portefeuille en ligne, portefeuille, EWallet, OnlineWallet">
        <meta name="robots" content="index, follow">
        <meta name="geo.placename" content="Manage, Hainaut">
        <meta name="geo.region" content="BE-WHT">
        <meta name="author" lang="en" content="Florian Di Vrusa">
        <meta name="generator" content="Intellij IDEA 2017.1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../../CSS/StyleLogin.css">
    </head>

    <body>

    <form method="post" action="Login.php">
        <div id="login">
            <h3> Login</h3>
            <input class="champ" type="text" name="Email" placeholder="Email"><br>
            <input class="champ" type="password" name="Pwd" placeholder="Password"><br>
            <input id="bouton" type="submit" value="Login" title="Login">
            <div id="creationCompte">
                <p><a href="../Display/Inscription.php"> Create an account </a></p>
            </div>
        </div>
    </form>

    </body>
    </html>

    <?php
} else {

    header("Location : Home.php");
}

?>