<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 11-05-17
 * Time: 11:29
 */

//Je n'inclus pas le header sinon j'ai des problèmes avec mes variables de sessions
session_start();

require_once ('../../Class/DBConnect.php');
require_once ('../../Class/OperationUser.php');
require_once ('../../Class/User.php');

    $dbConnect = new DBConnect();
    $dbConnect = $dbConnect->getDBConnection();

    $operationModif = new OperationUser($dbConnect);

    //Vu que j'ai tout vérifier avant, je peut directement modifier dans la BDD
    $operationModif->modifyUser($_SESSION['userMailToModify'],$_SESSION['Email'], $_SESSION['Name'], $_SESSION['FirstName'], $_SESSION['UserRight']);

    //Je récupère les infos de mon admin
    $dataAdmin = $operationModif->getUserInfo($_SESSION['mailAdmin']);

    //Je les place dans mes variables de sessions
    $_SESSION["Name"] = $dataAdmin['Name'];
    $_SESSION["FirstName"] = $dataAdmin['FirstName'];
    $_SESSION["Email"] =$dataAdmin['Email'];
    $_SESSION["Pwd"] =$dataAdmin['Pwd'];
    $_SESSION["UserRight"] =$dataAdmin['UserRight'];


    //Je redirige vers le home
    $operationModif->redirect("../UserPages/Home.php");

?>