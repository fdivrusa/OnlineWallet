<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 05-05-17
 * Time: 10:43
 */

include_once ("Header.php");

if(!isset($_SESSION["UserRight"])) {

    header("Location: ../Login_SignUp/Login.php");
}

elseif ($_SESSION["UserRight"] == 1) {

    header("Location: Home.php");
}

?>


