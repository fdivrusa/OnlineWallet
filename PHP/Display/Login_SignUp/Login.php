<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 01-04-17
 * Time: 16:21
 */

include("Header.php");
require_once("../../Class/DBConnect.php");
require_once("../../Class/OperationUser.php");

//Si l'utilisateur est déja logué, on le redirige vers sa page
if (!$_SESSION['UserRight'] >= 1 || $_SESSION['UserRight'] == 3) {

    if (isset($_POST['Email']) && isset($_POST['Pwd']) && !empty($_POST['Email']) && !empty($_POST['Pwd'])) {

        $email = $_POST['Email'];
        $pwd = $_POST['Pwd'];

        $dbConnect = new DBConnect();

        //Operation de Log
        $operationLog = new OperationUser($dbConnect);

        //Vérification si le mail est dans la BDD
        if ($operationLog->verifMailLogin($email) == true) {

            //Vérification si le mot de passe correspond au mail
            if ($operationLog->verifPasswordLogin($email, $pwd) == true) {

                //Ajout de l'utilisateur
                $operationLog->loginUser($email, $pwd);

            } else {

                $_SESSION['Error'] = "Make sure that your password is correct";
                $operationLog->redirect("Login.php");
            }

        } else {

            $_SESSION['Error'] = "Make sure that the Email is valid or already registered";
            $operationLog->redirect("Login.php");
        }

    } else {

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
            <link rel="stylesheet" type="text/css" href="../../../CSS/StyleLogin.css">
        </head>

        <body>

        <form method="post" action="Login.php">
            <div id="login">
                <h3> Login</h3>
                <h5><?php
                    //On regarde si il y a des erreurs que l'utilisateur à pu faire et on les effaces car elles sont affichées dans le formulaire lors de la redirection
                    if (isset($_SESSION['Error'])) {
                        $error = $_SESSION['Error'];
                        echo $error;
                        unset($_SESSION['Error']);
                    } else if (isset($_SESSION['Ban'])) {
                        $ban = $_SESSION['Ban'];
                        echo $ban;
                        unset($_SESSION['Ban']);
                    }
                    ?></h5>
                <input class="field" type="text" name="Email" placeholder="Email"><br>
                <input class="field" type="password" name="Pwd" placeholder="Password"><br>
                <input id="bouton" type="submit" value="Login" title="Login">

                <a id="passwordRecover" href="Recovery.php">Forgot password ?</a>

                <div id="accountCreation">
                    <p><a href="Inscription.php"> Create an account </a></p>
                </div>
            </div>
        </form>

        <footer>
            <a href="mailto:floriandv1996@gmail.com">Contact Admin</a>
            <p id="txtFooter">Website developped as part of the PHP course</p>
        </footer>

        </body>
        </html>

        <?php
    }

} else {

    header("Location: ../UserPages/Home.php");
}

?>