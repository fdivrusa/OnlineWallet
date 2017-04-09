<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 01-04-17
 * Time: 16:21
 */

include("Header.php");

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
    <meta name="author" lang="fr" content="Florian Di Vrusa">
    <meta name="generator" content="Intellij IDEA 2017.1">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../CSS/StyleLogin.css">
</head>

<body>

    <form method="post" action="Login.php">
        <div id="login">
            <h3>Login</h3>
            <input class="champ" type="text" name="Email" placeholder="Email"><br>
            <input class="champ" type="password" name="mdp" placeholder="Mot de passe"><br>
            <input id="bouton" type="submit" value="Se connecter" title="Connexion">
            <div id="creationCompte">
                <p><a href="../PHP/Inscription.php">Créer un compte OnlineWallet</a></p>
            </div>
        </div>
    </form>

</body>
</html>

