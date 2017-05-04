<?php
/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 29-04-17
 * Time: 11:25
 */

//Destruction de la session et "remise à 0" des variables de sessions
session_start();
session_unset();
session_destroy();

//Redirection vers le login
header("Location: Login_SignUp/Login.php");

?>
