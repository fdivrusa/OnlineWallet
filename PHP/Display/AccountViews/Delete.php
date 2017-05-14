<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 14-05-17
 * Time: 09:54
 */

session_start();
require_once ("../../Class/DBConnect.php");
require_once ("../../Class/OperationAccount.php");

if($_SESSION['UserRight'] >= 1) {

    $dbConnect = new DBConnect();
    $dbConnect = $dbConnect->getDBConnection();

    $operationDel = new OperationAccount($dbConnect);

    $operationDel->deleteAccount($_GET['idAccount']);

} else {

    header("Location: ../Login_SignUp/Login.php");
}

