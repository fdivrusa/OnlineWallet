<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 30-03-17
 * Time: 22:28
 */

include("Header.php");

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Inscription à OnlineWallet">
    <meta name="keywords"
          content="Banque en ligne, argent, Wallet, argent en ligne, portefeuille en ligne, portefeuille, EWallet, OnlineWallet">
    <meta name="robots" content="index, follow">
    <meta name="geo.placename" content="Manage, Hainaut">
    <meta name="geo.region" content="BE-WHT">
    <meta name="author" lang="fr" content="Florian Di Vrusa">
    <meta name="generator" content="Intellij IDEA 2017.1">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../CSS/StyleInscription.css">
</head>

<body>

<form method="post" action="Inscription.php">
    <div id="Inscription">
        <h3>Inscription</h3>
        <input class="champ" type="text" name="Email" placeholder="Email"><br>
        <input class="champ" type="text" name="Nom" placeholder="Nom"><br>
        <input class="champ" type="text" name="Prenom" placeholder="Prenom"><br>
        <input class="champ" type="password" name="mdp" placeholder="Mot de passe"><br>
        <input class="champ" type="password" name="verifMdp" placeholder="Vérification du mot de passe"><br>
        <input id="bouton" type="submit" value="Créer un compte" title="Création du compte">
        <div id="login">
            <p><a href="../PHP/Login.php">Se connecter</a></p>
        </div>
    </div>


</form>

</body>
</html>
