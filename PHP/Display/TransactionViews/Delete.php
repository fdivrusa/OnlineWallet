<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 14-05-17
 * Time: 09:54
 */

session_start();
require_once ("../../Class/DBConnect.php");
require_once ("../../Class/OperationTransaction.php");
require_once ("../../Class/OperationAccount.php");

if($_SESSION['UserRight'] >= 1) {

    $dbConnect = new DBConnect();
    $dbConnect = $dbConnect->getDBConnection();

    $operationDel = new OperationTransaction($dbConnect);
    $operationMajAccount = new OperationAccount($dbConnect);

    $operationMajAccount->modifyAccount($_SESSION['idAccount'], $_SESSION['AccountName'], $_SESSION['Type'], $_SESSION['Motto'], $_SESSION['Balance'] - $_GET['Value']);
    $operationDel->deleteTransaction($_GET['idTransaction']);


} else {

    header("Location: ../Login_SignUp/Login.php");
}

