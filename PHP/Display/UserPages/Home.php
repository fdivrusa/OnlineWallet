<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 20-04-17
 * Time: 12:22
 */

include_once("Header.php");
require_once ("../../Class/User.php");

//Si l'admin est connecté, on liste tout les utilisateurs
if ($_SESSION['UserRight'] == 2) {

    $dbConnect = new DBConnect();
    $dbConnect = $dbConnect->getDBConnection();

    $recupInfo = new OperationUser($dbConnect);

    //Récupération des infos de l'utilisateur grâce à son adresse mail
    $data = $recupInfo->getUserInfo($_SESSION['Email']);

    //Je récupère l'adresse mail de l'admin
    $_SESSION['mailAdmin'] = $data['Email'];

    $req = $dbConnect->query("SELECT * FROM users");
    $admin = $req->fetch();

    //Si tout est correct
    if(isset($_POST['Email']) && isset($_POST['Name']) && isset($_POST['FirstName']) && isset($_POST['UserRight'])
            && !empty($_POST['Email']) && !empty($_POST['Name']) && !empty($_POST['FirstName']) && !empty($_POST['UserRight'])) {

        //Je passe les données dans mes variables de sessions
        $_SESSION['userMailToModify'] = $_POST['hiddenEmail'];
        $_SESSION['Email'] = $_POST['Email'];
        $_SESSION['Name'] = $_POST['Name'];
        $_SESSION['FirstName'] = $_POST['FirstName'];
        $_SESSION['UserRight'] = $_POST['UserRight'];

        $test['test'] = $_SESSION['Email'];

        //Je redirige vers la page qui enregistrera tout dans la DB et renverra ici
        header("Location: ../Admin/AdminModif.php");

    } else {

        while ($data = $req->fetch()) {

            ?>
            <div id="users">

                <div id="display">

                    <form action="Home.php" method="POST">

                        <div id="info">

                            <!--J'utiliserais le champ Hidden pour savoir chez quel utilisateur je dois modifier les infos-->
                            <input type="hidden" name="hiddenEmail" value="<?php echo $data['Email'] ?>" >

                            <input pattern="[\w\-\+]+(\.[\w\-]+)*@[\w\-]+(\.[\w\-]+)*\.[\w\-]{2,4}" title="Please enter a valid Email" placeholder="Email" name="Email" type="text" value="<?php echo $data['Email'] ?>">
                            <input pattern="[A-Za-z -]{2,}" title="Only valid name" placeholder="Name" name="Name" type="text" value="<?php echo $data['Name'] ?>">
                            <input pattern="[A-Za-z -]{2,}" title="Only valid firstname" placeholder="FirstName" name="FirstName" type="text" value="<?php echo $data['FirstName'] ?>">
                            <input placeholder="UserRight" name="UserRight" type="text" value="<?php echo $data['UserRight'] ?>">

                        </div>

                        <input id="buttonModif" class="button" type="submit" value="Modify user">

                        <button class="button">Delete User</button>

                    </form>

                </div>

            </div>

            <?php

        }
    }

} else if ($_SESSION['UserRight'] == 1) {


} else {

    header("Location: ../Login_SignUp/Login.php");
}


?>




