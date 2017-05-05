<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 05-05-17
 * Time: 11:02
 */

include_once("Header.php");

if (!isset($_SESSION["UserRight"])) {

    //Si l'utilisateur n'est pas connecté, on le redirige vers le Login
    header("Location: ../Login_SignUp/Login.php");

    if(!isset($_POST["Email"]) && !isset($_POST["Name"]) && !isset($_POST["FirstName"])
        && empty($_POST["Email"]) && empty($_POST["Name"]) && empty($_POST["FirstName"])) {

        //Code de modif dans BDD et redirection dans le Home
    }

} else {

    //Création de l'utilisateur à modifier
    $userToModify = new User($_SESSION['Email'], $_SESSION["Name"], $_SESSION["FirstName"], $_SESSION["Pwd"], $_SESSION["UserRight"]);
}

?>

<html>

<head>
    <link rel="stylesheet" href="../../../CSS/StyleUserModification.css">
</head>

<body>

<!--Le formulaire de modification sera pré-remplit-->

<form method="POST" action="UserModification.php">

    <div id="modification">

        <h4>Modification</h4>

        <input class="field" type="text" name="Email" placeholder="Email" value="<?php echo $userToModify->getMail();?>"><br>
        <input class="field" pattern="[A-Za-z -]{2,}" title="Only valid name" type="text" name="UserName"
               placeholder="Name" value="<?php echo $userToModify->getName(); ?>"><br>

        <input class="field" pattern="[A-Za-z -]{2,}" title="Only valid firstname" type="text" name="FirstName"
               placeholder="Firstname" value="<?php echo $userToModify->getFirstName(); ?>"><br>

        <input type="submit" value="Modify" title="Modify">
        <button type="submit"><a href="PasswordModification.php">Modify Password</a></button>

    </div>
</form>



</body>
</html>