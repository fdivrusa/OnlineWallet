<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 05-05-17
 * Time: 14:14
 */

include_once("Header.php");

$dbConnect = new DBConnect();
$dbConnect = $dbConnect->getDBConnection();
$operationModifPwd = new OperationUser($dbConnect);

if($_SESSION['UserRight'] >= 1) {


    //Vérification
    if (isset($_POST['oldPwd']) && isset($_POST['newPwd']) && isset($_POST['newPwdConf']) &&
        !empty($_POST['oldPwd']) && !empty($_POST['newPwd']) && !empty($_POST['newPwdConf'])) {

        if($_POST['newPwd'] == $_POST['newPwdConf']) {

            $operationModifPwd->passwordModif($_POST['oldPwd'], $_POST['newPwd']);

        } else {

            $_SESSION['Error'] = "Your passwords not match ! Try again";
        }
    }

    ?>

    <html>

    <head>
        <link rel="stylesheet" href="../../../CSS/StyleUserModification.css">
    </head>

<body>

<!--Le formulaire de modification de mot de passe-->

<form method="POST" action="PasswordModification.php">

    <div id="modification">

        <h4>Password modification</h4>
        <h5><?php
            if (isset($_SESSION['Error'])) {
                $error = $_SESSION['Error'];
                echo $error;
                unset($_SESSION['Error']);
            }; ?></h5>
        <input class="field" type="password" name="oldPwd" placeholder="Actual password"><br>

        <input class="field" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Enter password with at least 8 characters, 1 UPPERCASE letter, 1 lowercase and 1 number"
               class="champ" type="password" name="newPwd" placeholder="New Password"><br>

        <input class="field" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Enter password with at least 8 characters, 1 UPPERCASE letter, 1 lowercase and 1 number"
               type="password" name="newPwdConf" placeholder="Confirm new password"><br>

        <input id="button" type="submit" value="Modify password" title="Modify password">

    </div>
</form>

    <?php

} else {

    //Redirection vers le Login
    header("Location: ../Login_SignUp/Login.php");
}

