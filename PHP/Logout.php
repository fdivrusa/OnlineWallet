<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 20-04-17
 * Time: 10:40
 */

    if($_SESSION['userRight'] >= 1) {

        session_start(); //Nouvelle page donc il faut remettre session_start()
        session_unset(); //Destruction des variables de sessions
        session_destroy(); //Destruction de la session
        header("Location : ../PHP/Login.php"); //Je renvoie l'utilisateur à la page de Login
    }