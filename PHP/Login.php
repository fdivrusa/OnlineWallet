<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 01-04-17
 * Time: 16:21
 */

include("Header.php");

if (!$_SESSION['userRight'] >= 1) { //On vérifie si l'utilisateur est déja connecté


}
?>

<?php

if (isset($_POST['Email']) && isset($_POST['Pwd'])) { //On vérifie si les champs sont remplis

    try {
        include_once("DB.php");
        $pwd = sha1($_POST['Pwd']);
        $droits = 1;
        $bd = new PDO('mysql:host=' . $hote . ';dbname=' . $nomDB, $user, $mdp);
        $req = $bd->prepare('SELECT Email, Pwd, UserRight FROM users WHERE Pwd = :Pwd AND Email = :Email'); //Vérification de l'exactitude de l'email et du mdp
        $req->execute(array( //Execution de la requête
            'Email' => $_POST['Email'],
            'Pwd' => $pwd
        ));
        $donnees = $req->fetch();

        if (!empty($donnees)) { //Si c'est ok, on enregistre les données dans les variables de sessions et on redirige vers l'accueil

            $_SESSION['UserRight'] = $donnees['UserRight'];
            $_SESSION['Email'] = $donnees['Email'];
            header("Location: Accueil.php");

        } else { //Sinon on met un message d'erreur

            $_SESSION['UserRight'] = 0;
            echo "Identifiants incorrect";
        }

    } catch (Exception $e) {

        echo "An error has occured" . $e;
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
        <input class="champ" type="password" name="Pwd" placeholder="Password"><br>
        <input id="bouton" type="submit" value="Login" title="Login">
        <div id="creationCompte">
            <p><a href="../PHP/Inscription.php">Create an account</a></p>
        </div>
    </div>
</form>

</body>
</html>

