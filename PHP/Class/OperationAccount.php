<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 30-04-17
 * Time: 19:17
 */
require_once("DBConnect.php");

class OperationAccount
{
    private $dbConnect;

    function __construct($dbConnect)
    {
        $this->dbConnect = new DBConnect();
        $this->dbConnect = $this->dbConnect->getDBConnection();
    }

    //----Opération sur la BDD-----//

    /**
     * @param $mail
     * @param $name
     * @param $firstname
     * @param $pwd
     * @param $userRight
     *
     * Fonction permettant d'ajouter un utilisateur à la BDD
     */
    public function addAccount($userMail, $accountName, $type, $motto, $balance)
    {
        try {
            //Préparation de la requête d'insertion
            $req = $this->dbConnect->prepare("INSERT INTO accounts (UserMail, AccountName, Type, Motto, Balance) 
                                                        VALUES (:userMail, :accountName, :type, :motto, :balance)");

            //Association de mes variables
            $req->bindParam(":userMail", $userMail);
            $req->bindParam(":accountName", $accountName);
            $req->bindParam(":type", $type);
            $req->bindParam(":motto", $motto);
            $req->bindParam(":balance", $balance);
            $req->execute();

            //Ajout des infos dans mes variables de session
            $_SESSION['AccountName'] = $accountName;
            $_SESSION['Type'] = $type;
            $_SESSION['Motto'] = $motto;
            $_SESSION['Balance'] = $balance;

        } catch (PDOException $e) {

            echo $e;
        }

        //Redirection de l'utilisateur sur sa page
        $this->redirect("../UserPages/Home.php");
    }

    /**
     * @param $url
     * redirige l'utilisateur vers l'url passée en paramètre
     */
    public function redirect($url)
    {
        header("Location: $url");
    }
}