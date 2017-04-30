<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 30-04-17
 * Time: 19:17
 */
require_once("DBConnect.php");

class Operation
{

    private $dbConnect;
    private $salt = 'D6Ooihzkld55wxfciIHODJL';


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
    function addUser($mail, $name, $firstname, $pwd, $userRight)
    {

        $pwdHash = hash('sha256', $this->getSalt(), $pwd);

        $req = $this->dbConnect->prepare("INSERT INTO users VALUES (:email, :name, :firstName, :pwd, :userRight)");

        //Association de mes variables
        $req->bindParam(":email", $mail);
        $req->bindParam(":name", $name);
        $req->bindParam(":firstName", $firstname);
        $req->bindParam(":pwd", $pwdHash);
        $req->bindParam(":userRight", $userRight);
        $req->execute();

        //Ajout du mail dans la variable de session
        $_SESSION['Email'] = $mail;

        //Redirection de l'utilisateur sur sa page
        //$this->redirect("../Display/Home.php");
    }

    /**
     * @param $email
     * @param $pwd
     * Fonction permettant de loguer un utilisateur
     */
    public function loginUser($email, $pwd)
    {
        try {
            //Hash du mdp récupéré en paramètre (pour le passer dans la requête)
            $pwdHasher = hash("sha256", $this->salt . $pwd);

            //requête
            $req = $this->dbConnect->prepare("SELECT * FROM users WHERE Email = :Email AND Pwd = :Pwd");

            //Association des variables
            $req->bindParam(":Email", $email);
            $req->bindParam(":Pwd", $pwdHasher);
            $req->execute();

            //Récupération des infos
            $userInfo = $req->fetch(PDO::FETCH_ASSOC);
            if ($req->rowCount() > 0) { //Si les infos sont présentes

                //Je place mon email dans ma variable de session
                $_SESSION['Email'] = $userInfo['Email'];

            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //----Vérifications des paramètres----//


    /**
     * @param $email
     * @return bool
     */
    public function verifMailInscription($email)
    {
        //Connexion à ma BDD
        $dbConnect = new DBConnect();
        $dbConnect = $dbConnect->getDBConnection();

        //Je récupère tout en minuscule et sans espaces
        $email = strtolower(trim($email));

        //Requête de recherche dans la BDD
        $req = $dbConnect->prepare("SELECT * FROM users WHERE Email = :email");
        $req->bindParam(":email", $email);
        $req->execute();
        $data = $req->fetch();

        //Je vérifie avec la fonction si l'adresse est valide
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            //Si elle est valide, je regarde que l'adresse n'est pas déja dans la DB
            if ($data['Email'] == $email) {

                return false;
            }

            return true;

        } else {

            return false;
        }
    }

    public function verifMailLogin()
    {


    }

    /**
     * @param $pwd
     * @param $pwdVerif
     * @return bool
     */
    public function verifPassword($pwd, $pwdVerif)
    {
        $pwd = trim($pwd);
        $pwdVerif = trim($pwdVerif);

        if ($pwd != $pwdVerif) {

            return false;
        } else {

            return true;
        }
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
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