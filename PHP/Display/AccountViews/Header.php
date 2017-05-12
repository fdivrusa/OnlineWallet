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


if (!isset($_SESSION['Email'])) {

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

    //Variables de sessions
    $_SESSION["Name"] = $user->getName();
    $_SESSION["FirstName"] = $user->getFirstName();
    $_SESSION["Email"] = $user->getMail();
    $_SESSION["Pwd"] = $user->getPwd();
    $_SESSION["UserRight"] = $user->getUserRight();
}

?>

<head>
    <link rel="stylesheet" href="../../../CSS/StyleHome.css">
</head>

<body>
<div id="background">
    <img src="../../../Images/BackgroundIndex.jpg" alt="">
</div>

<header>
    <div id="userInfo">
        <h2><?php echo $user->getName(); ?></h2>
        <h3><?php echo $user->getFirstName(); ?></h3>
    </div>
    <div id="options">
        <h2><a href="../UserPages/Home.php">Home</a></h2>
        <h2><a id="logout" href="../Logout.php">Logout</a></h2>
        <h2><a href="../UserPages/UserModification.php">Account modification</a></h2>
    </div>
    <div id="title">
        <h1><?php echo 'TEST' ?></h1>
    </div>

</header>

</body>