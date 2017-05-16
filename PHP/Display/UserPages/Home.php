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

    //Si tout est correct
    if(isset($_POST['Email']) && isset($_POST['Name']) && isset($_POST['FirstName']) && isset($_POST['UserRight'])
            && !empty($_POST['Email']) && !empty($_POST['Name']) && !empty($_POST['FirstName']) && !empty($_POST['UserRight'])) {

        //Je passe les données dans mes variables de sessions
        $_SESSION['userMailToModify'] = $_POST['hiddenEmail'];
        $_SESSION['Email'] = $_POST['Email'];
        $_SESSION['Name'] = $_POST['Name'];
        $_SESSION['FirstName'] = $_POST['FirstName'];
        $_SESSION['UserRight'] = $_POST['UserRight'];

        //Je redirige vers la page qui enregistrera tout dans la DB et renverra ici
        header("Location: ../Admin/AdminModif.php");

    } else {

        while ($data = $req->fetch()) {


            ?>
            <section id="users">

                <div id="display">

                    <form action="Home.php" method="POST">

                        <div id="info">

                            <!--J'utiliserais le champ Hidden pour savoir chez quel utilisateur je dois modifier les infos-->
                            <input id="hiddenEmail" type="hidden" name="hiddenEmail" value="<?php echo $data['Email'] ?>" >

                            <input pattern="[\w\-\+]+(\.[\w\-]+)*@[\w\-]+(\.[\w\-]+)*\.[\w\-]{2,4}" title="Please enter a valid Email" placeholder="Email" name="Email" type="text" value="<?php echo $data['Email'] ?>">
                            <input pattern="[A-Za-z -]{2,}" title="Only valid name" placeholder="Name" name="Name" type="text" value="<?php echo $data['Name'] ?>">
                            <input pattern="[A-Za-z -]{2,}" title="Only valid firstname" placeholder="FirstName" name="FirstName" type="text" value="<?php echo $data['FirstName'] ?>">
                            <input pattern="[1-3]{1}" title="UserRight can only be between 1 and 3" placeholder="UserRight" name="UserRight" type="text" value="<?php echo $data['UserRight'] ?>">

                        </div>

                        <a id= "resetPassword" class="link" href="../Admin/PasswordReset.php">Reset user password</a>

                        <input type="submit" id="modifyAdmin" value="Modify user">
                    </form>

                    <a id="deleteAccount" class="link" href="../Delete.php?Email=<?php echo ($data['Email']);?>">Delete User</a>
                </div>

            </section>
            
            <?php

        }
    }

} else if ($_SESSION['UserRight'] == 1) { //Si un utilisateur normal est connecté, on liste les comptes

    //Je récupère tout les comptes de l'utilisateurs actuellement connecté
    $req = $dbConnect->prepare("SELECT * FROM accounts WHERE UserMail = :userMail");
    $req->bindParam(":userMail", $_SESSION['Email']);
    $req->execute();

    while($dataAccount = $req->fetch()) {

        ?>

        <section id="accounts">

            <div id="display">

                    <div id="info">

                        <input type="hidden" value="<?php echo $dataAccount['idAccount']?>">
                        <h2><?php echo $dataAccount['AccountName']?></h2>
                        <h4>Type : <?php echo $dataAccount['Type']?></h4>
                        <h4>Motto : <?php echo $dataAccount['Motto']?></h4>
                        <h4>Balance : <?php echo $dataAccount['Balance']?></h4>

                    </div>

                    <a id="viewAccount" class="link" href="../TransactionViews/TransactionsView.php?idAccount=<?php echo $dataAccount['idAccount']?>">Account View</a>

                    <a id="deleteAccount" class="link" href="../AccountViews/Delete.php?idAccount=<?php echo $dataAccount['idAccount']?>">Delete Account</a><br>

                    <div id="modifyAccount" >
                        <a href="../AccountViews/AccountModification.php?idAccount=<?php echo $dataAccount['idAccount']?>">Modify Account</a>
                    </div>
            </div>

        </section>

        <?php

    }

    ?>

    <div id="addButton">
        <a id="addAccount" href="../AccountViews/AddAccount.php">Add an Account</a>
    </div>

<?php

} else if($_SESSION['UserRight'] == 3) {

    $_SESSION['Ban'] = 'You are ban. Contact admin for more informations.';
    header("Location: ../Login_SignUp/Login.php");
}
else {

    header("Location: ../Login_SignUp/Login.php");
}


?>




