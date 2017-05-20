<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 30-04-17
 * Time: 19:17
 */
require_once("DBConnect.php");

class OperationTransaction
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
    public function addTransaction($idAccount, $title, $category, $value, $date)
    {

        try {
            //Préparation de la requête d'insertion
            $req = $this->dbConnect->prepare("INSERT INTO transactions (idAccount, Title, Category, Value, Date) 
                                                        VALUES (:idAccount, :title, :category, :value, :date)");

            //Association de mes variables
            $req->bindParam(":idAccount", $idAccount);
            $req->bindParam(":title", $title);
            $req->bindParam(":category", $category);
            $req->bindParam(":value", $value);
            $req->bindParam(":date", $date);
            $req->execute();

            //Ajout des infos dans mes variables de session
            $_SESSION['Title'] = $title;
            $_SESSION['Category'] = $category;
            $_SESSION['Value'] = $value;
            $_SESSION['Date'] = $date;
            $_SESSION['Balance'] = $_SESSION['Balance'] + ($value);

        } catch (PDOException $e) {

            echo $e;
        }

        //Redirection de l'utilisateur sur sa page
        $this->redirect("../TransactionViews/TransactionsView.php");
    }

    public function deleteTransaction($idTransaction)
    {
        $req = $this->dbConnect->prepare("DELETE FROM transactions WHERE idTransaction = :idTransaction");
        $req->bindParam(":idTransaction", $idTransaction);
        $req->execute();

        $this->redirect("../TransactionViews/TransactionsView.php");
    }

    public function getTransactionInfo($idTransaction)
    {

        //Connexion à la BDD
        $dbConnect = new DBConnect();
        $dbConnect = $dbConnect->getDBConnection();

        $req = $dbConnect->prepare("SELECT * FROM transactions WHERE idTransaction = :idTransaction");
        $req->bindParam(":idTransaction", $idTransaction);
        $req->execute();
        $data = $req->fetch();

        return $data;
    }

    //Modifie les valeurs de la transaction dans la BDD
    public function modifyTransaction($idTransaction, $newTitle, $newCategory, $newValue, $newDate)
    {
        $req = $this->dbConnect->prepare("UPDATE transactions SET Title = :newTitle, Category = :newCategory, Value = :newValue, Date = :newDate WHERE idTransaction = :idTransaction");
        $req->bindParam(":newTitle", $newTitle);
        $req->bindParam(":newCategory", $newCategory);
        $req->bindParam(":newValue", $newValue);
        $req->bindParam(":newDate", $newDate);
        $req->bindParam(":idTransaction", $idTransaction);
        $req->execute();
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