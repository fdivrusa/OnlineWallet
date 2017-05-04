<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 04-05-17
 * Time: 10:24
 */

require_once("../../Class/User.php");
require_once("../../Class/DBConnect.php");
require_once("../../Class/OperationUser.php");

session_start();

if(!isset($_SESSION['Email'])) {

    //Si l'utilisateur essaye d'accéder à sa page sans se connecter, on le redirige vers le login
    header("Location: ../Login_SignUp/Login.php");
} else {

    //Connexion à la BDD
    $dbConnect = new DBConnect();
    $dbConnect = $dbConnect->getDBConnection();

    $operationUser = new OperationUser($dbConnect);

    //Récupération des infos de l'utilisateur grâce à son adresse mail
    $data = $operationUser->getUserInfo($_SESSION['Email']);

    //Construction d'un objet utilisateur
    $user = new User($data['Email'], $data['Name'], $data['FirstName'], $data['Pwd'], $data['UserRight']);


}

?>

<head>
    <link rel="stylesheet" href="../../../CSS/StyleHome.css">
</head>

<body>
    <header>
        <div id="userInfo">
            <h3></h3>
            <h4></h4>
        </div>
    </header>
</body>