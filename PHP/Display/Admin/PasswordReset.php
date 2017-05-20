<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 16-05-17
 * Time: 09:36
 *
 */

session_start();
require_once("../../Class/OperationUser.php");

if ($_SESSION['UserRight'] >= 1) {

    $dbConnect = new DBConnect();
    $dbConnect->getDBConnection();

    $resetOperation = new OperationUser($dbConnect);
    $resetOperation->resetUserPwd($_GET['Email']);

} else {

    header("Location: ../");
}

