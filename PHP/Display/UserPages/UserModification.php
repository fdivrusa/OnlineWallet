<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 05-05-17
 * Time: 11:02
 */

include_once("Header.php");
require_once("../../Class/DBConnect.php");

$dbConnect = new DBConnect();
$userToModify = new User($_SESSION['Email'], $_SESSION['Name'], $_SESSION['FirstName'], $_SESSION['Pwd'], $_SESSION['UserRight']);
$operationMod = new OperationUser($dbConnect);

//Si l'utilisateur est bien logué
if ($_SESSION['UserRight'] >= 1) {


    //On vérifie si les informations sont bien présentes
    if (isset($_POST['Email']) && isset($_POST['Name']) && isset($_POST['FirstName']) &&
        !empty($_POST['FirstName']) && !empty($_POST['Name']) && !empty($_POST['Email'])) {

        //On vérifie si la nouvelle adresse mail est différente de l'actuelle
        if ($_POST['Email'] != $userToModify->getMail()) {

            //Si elle n'est pas dans la BDD, on la change
            if (($operationMod->verifMailNotInDB($_POST['Email'])) == true) {

                //On peut modifier les infos dans la BDD
                $operationMod->modifyUser($_SESSION['Email'], $_POST['Email'], $_POST['Name'], $_POST['FirstName'], $_SESSION['UserRight']);
                $_SESSION["Email"] = $_POST['Email'];
                header("Location: Home.php");


            } else {

                $_SESSION['Error'] = "Mail is already used by an other user or is not valid. Please try again";
            }

        } else {

            //On modifie quand même, même si il ne change pas son mail
            $operationMod->modifyUser($_SESSION['Email'], $_POST['Email'], $_POST['Name'], $_POST['FirstName'], $_SESSION['UserRight']);
            header("Location: Home.php");
        }
    }

    ?>

    <html>

    <head>
        <link rel="stylesheet" href="../../../CSS/StyleUserModification.css">
    </head>

    <body>

    <!--Le formulaire de modification-->

    <form method="POST" action="UserModification.php">

        <div id="modification">

            <h4>Modification</h4>
            <h5><?php
                if (isset($_SESSION['Error'])) {
                    $error = $_SESSION['Error'];
                    echo $error;
                    unset($_SESSION['Error']);
                }; ?></h5>
            <input class="field" type="text" name="Email" placeholder="Email"
                   value="<?php echo $userToModify->getMail(); ?>"><br>
            <input class="field" pattern="[A-Za-z -]{2,}" title="Only valid name" type="text" name="Name"
                   placeholder="Name" value="<?php echo $userToModify->getName(); ?>"><br>

            <input class="field" pattern="[A-Za-z -]{2,}" title="Only valid firstname" type="text" name="FirstName"
                   placeholder="Firstname" value="<?php echo $userToModify->getFirstName(); ?>"><br>

            <input id="buttonModif" type="submit" value="Modify" title="Modify">
            <button id="buttonModifPwd" type="submit"><a href="PasswordModification.php">Modify Password</a></button>

        </div>
    </form>

    <div id="delButton">
        <h2><a href="DeleteVerif.php">Delete Account</a></h2>
    </div>

    </body>
    </html>

    <?php


} else {

    //Redirection vers le Login
    header("Location: ../Login_SignUp/Login.php");

}

?>