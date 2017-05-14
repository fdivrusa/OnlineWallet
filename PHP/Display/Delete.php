<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 11-05-17
 * Time: 11:28
 */


session_start();
require_once ('../Class/DBConnect.php');
require_once ('../Class/OperationUser.php');
require_once ('../Class/User.php');


$dbConnect = new DBConnect();
$dbConnect = $dbConnect->getDBConnection();

$operationModif = new OperationUser($dbConnect);

//Je supprime l'utilisateur voulu (version admin)

if(isset($_GET['Email'])) {

    $operationModif->deleteUser($_GET['Email']);

} else {

    $operationModif->deleteUser($_SESSION['Email']);
}



