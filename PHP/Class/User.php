<?php

/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 27-04-17
 * Time: 08:52
 */
class User
{

    private $_dbConnection;
    private $salt = "LDOKJ846LKDM6dsd";

    function __construct()
    {
        $this->_dbConnection = new DBConnect();
        $this->_dbConnection = $this->_dbConnection->getDBConnection(); //Je récupère la connexion
    }

    //Fonction permettant d'ajouter un utilisateur dans ma BDD
    public function addUser($email, $userName, $firstname, $pwd, $userRight)
    {
        try {

            //Hash du mot de passe avec grain de sel

            $password = hash("sha256", $this->salt . $pwd);

            //requête
            $req = $this->_dbConnection->prepare("INSERT INTO users VALUES (:email, :name, :firstName, :pwd, :userRight)");

            //Association de mes variables
            $req->bindParam(":email", $email);
            $req->bindParam(":name", $userName);
            $req->bindParam(":firstName", $firstname);
            $req->bindParam(":pwd", $password);
            $req->bindParam(":userRight", $userRight);
            $req->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
            $req = $this->_dbConnection->prepare("SELECT * FROM users WHERE Email = :Email AND Pwd = :Pwd");
            $req->bindParam(":Email", $email);
            $req->bindParam(":Pwd", $pwdHasher);
            $req->execute();

            $userInfo = $req->fetch(PDO::FETCH_ASSOC); //Récupération des infos

            if ($req->rowCount() > 0) { //Si les infos sont présentes

                //Je les places dans mes variables de sessions
                $_SESSION['Name'] = $userInfo['Name'];
                $_SESSION['Email'] = $userInfo['Email'];
                $_SESSION['FirstName'] = $userInfo['FirstName'];
                $_SESSION['UserRight'] = $userInfo['UserRight'];

                echo $_SESSION['Name'];
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return string : le grain de sel utilisé pour le hachage
     */
    public function getSalt()
    {
        return $this->salt;
    }


    /**
     * @return bool : true si l'utilisateur est connecté
     */
    public function is_loggedin()
    {
        if (isset($_SESSION['Email'])) {
            return true;
        }
    }

    /**
     * @param $url : Le chemin vers lequel redirigé l'utilisateur
     */
    public function redirection($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        //Destruction des variables de la sessions
        $_SESSION = array();

        //Destruction de la session
        session_destroy();

    }
}
            
            
            
            
            
            
            
            
