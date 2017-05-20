<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 30-04-17
 * Time: 19:17
 */
require_once("DBConnect.php");

class OperationUser
{
    private $dbConnect;
    private $salt = 'D6Oik5wciDJL';

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
        //Hash du mdp
        $pwdHash = hash("sha512", $this->salt . $pwd);

        try {
            //Préparation de la requête d'insertion
            $req = $this->dbConnect->prepare("INSERT INTO users VALUES (:email, :name, :firstName, :pwd, :userRight)");

            //Association de mes variables
            //J'utilises BindParam pour avoir une vue d'ensemble et que ça soit plus propre
            $req->bindParam(":email", $mail);
            $req->bindParam(":name", $name);
            $req->bindParam(":firstName", $firstname);
            $req->bindParam(":pwd", $pwdHash);
            $req->bindParam(":userRight", $userRight);
            $req->execute();

            //Ajout des infos dans mes variables de session
            $_SESSION['Email'] = $mail;
            $_SESSION['UserRight'] = $userRight;

        } catch (PDOException $e) {

            echo $e;
        }

        //Redirection de l'utilisateur sur sa page
        $this->redirect("../UserPages/Home.php");
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
            $pwdHash = hash("sha512", $this->salt . $pwd);

            //requête
            $req = $this->dbConnect->prepare("SELECT * FROM users WHERE Email = :Email AND Pwd = :Pwd");

            //Association des variables
            $req->bindParam(":Email", $email);
            $req->bindParam(":Pwd", $pwdHash);
            $req->execute();

            //Récupération des infos
            $userInfo = $req->fetch();
            if ($req->rowCount() > 0) { //Si les infos sont présentes

                //Je place l'email et le droit dans mes variable de session
                $_SESSION['Email'] = $userInfo['Email'];
                $_SESSION['UserRight'] = $userInfo['UserRight'];

            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $this->redirect("../UserPages/Home.php");
    }

    //Modifie les valeurs de l'utilisateurs dans la BDD
    public function modifyUser($oldEmail, $newEmail, $newName, $newFirstName, $newUserRight)
    {
        $req = $this->dbConnect->prepare("UPDATE users SET Email = :newEmail, Name = :name, FirstName = :firstName, UserRight = :userRight WHERE  Email = :oldEmail");
        $req->bindParam(":newEmail", $newEmail);
        $req->bindParam(":name", $newName);
        $req->bindParam(":firstName", $newFirstName);
        $req->bindParam(":oldEmail", $oldEmail);
        $req->bindParam(":userRight", $newUserRight);
        $req->execute();
    }

    public function deleteUser($email)
    {

        $req = $this->dbConnect->prepare("DELETE FROM users WHERE Email = :email");
        $req->bindParam(":email", $email);
        $req->execute();

        //je redirige toujours vers le login, de toute façon, si l'admin supprime des utilisateurs, il sera redirigé sur son home
        $this->redirect("../Display/Login_SignUp/Login.php");
    }
    //----Vérifications des paramètres----//

    /**
     * @param $email
     * @return bool
     */
    public function verifMailNotInDB($email)
    {
        //Connexion à ma BDD
        $dbConnect = new DBConnect();
        $dbConnect = $dbConnect->getDBConnection();

        //Je récupère tout en minuscule et sans espaces
        $email = strtolower($email);

        //Requête de recherche dans la BDD
        $req = $dbConnect->prepare("SELECT * FROM users WHERE Email = :email");
        $req->bindParam(":email", $email);
        $req->execute();

        //Je vérifie avec la fonction si l'adresse est valide
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            //Si elle est valide, je regarde que l'adresse n'est pas déja dans la DB
            if ($req->rowCount() == 0) {

                return true;

            } else {

                return false;
            }

        } else {

            return false;
        }
    }

    /**
     * @param $pwd
     * @param $pwdVerif
     * @return bool
     */
    public function verifPasswordInscription($pwd, $pwdVerif)
    {
        if ($pwd != $pwdVerif) {

            return false;
        } else {

            return true;
        }
    }

    public function verifMailLogin($email)
    {
        //Connexion à la BDD
        $dbConnect = new DBConnect();
        $dbConnect = $dbConnect->getDBConnection();

        //Récupération de l'adresse
        $email = trim($email);

        //Requête de recherche dans la BDD
        $req = $dbConnect->prepare("SELECT * FROM users WHERE Email = :email");
        $req->bindParam(":email", $email);
        $req->execute();
        $data = $req->fetch();

        //Vérification si l'email est valide
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            //Si elle est valide, il faut qu'elle sois déja dans la DB
            if ($data['Email'] == $email) {

                return true;

            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    public function verifPasswordLogin($mail, $pwd)
    {
        //Hash du mdp
        $pwdHash = hash("sha512", $this->salt . $pwd);

        //Connexion à la BDD
        $dbConnect = new DBConnect();
        $dbConnect = $dbConnect->getDBConnection();

        //Requête de recherche du mdp
        $req = $dbConnect->prepare("SELECT * FROM users WHERE Email = :email AND Pwd = :pwd");
        $req->bindParam(":email", $mail);
        $req->bindParam(":pwd", $pwdHash);
        $req->execute();
        $data = $req->fetch();

        if ($data['Pwd'] == $pwdHash) {

            return true;
        } else {

            return false;
        }
    }

    public function passwordModif($oldPwd, $newPwd)
    {
        //Si le mot de passe se trouve dans la DB, on continue
        if ($this->verifPasswordLogin($_SESSION['Email'], $oldPwd)) {

            //Connexion à la BD
            $dbConnect = new DBConnect();
            $dbConnect = $dbConnect->getDBConnection();

            //Hash du nouveau mdp
            $newPwdHash = hash("sha512", $this->salt . $newPwd);

            //Modification dans la DB du mot de passe
            $req = $dbConnect->prepare("UPDATE users SET Pwd = :pwd WHERE :email = Email");
            $req->bindParam(":pwd", $newPwdHash);
            $req->bindParam(":email", $_SESSION['Email']);
            $req->execute();

            header("Location: ../UserPages/Home.php");

        } else {

            $_SESSION['Error'] = "Make sure that your actual password is correct !";
        }
    }

    public function getUserInfo($email)
    {

        //Connexion à la BDD
        $dbConnect = new DBConnect();
        $dbConnect = $dbConnect->getDBConnection();

        $req = $dbConnect->prepare("SELECT * FROM users WHERE Email = :email");
        $req->bindParam(":email", $email);
        $req->execute();
        $data = $req->fetch();

        return $data;
    }

    public function resetUserPwd($email)
    {
        $newPwd = "test";
        $subject = "Password Recovery Procedure [No Reply]";
        $text = "Your new password is \"test\".\nDon't forget to change your password when you login again !";

        //Hash du nouveau mot de passe
        $pwdHash = hash("sha512", $this->salt . $newPwd);

        //Je le remplace dans la BDD
        $req = $this->dbConnect->prepare("UPDATE users SET Pwd = :newPwd WHERE Email = :email");
        $req->bindParam(":newPwd", $pwdHash);
        $req->bindParam(":email", $email);
        $req->execute();

        $this->redirect("../UserPages/Home.php");

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