<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 16-05-17
 * Time: 09:25
 */

include_once("../AccountViews/Header.php");
require_once("../../Class/DBConnect.php");


//Si l'utilisateur est logué, on lui propose d'ajouter une transaction tout en lui affichant les autres
if ($_SESSION['UserRight'] >= 1) {


//Je récupère tout les comptes de l'utilisateurs actuellement connecté
    $req = $dbConnect->prepare("SELECT * FROM transactions WHERE idAccount = :idAccount");
    $req->bindParam(":idAccount", $_SESSION['idAccount']);
    $req->execute();

    while ($dataTransactions = $req->fetch()) {

        ?>

        <head>
            <link rel="stylesheet" href="../../../CSS/StyleTransaction.css">
        </head>

        <section id="accounts">

            <div id="display">

                <div id="info">

                    <input type="hidden" value="<?php echo $dataTransactions['idTransaction'] ?>">
                    <h2><?php echo $dataTransactions['Title'] ?></h2>
                    <h4>Category : <?php echo $dataTransactions['Category'] ?></h4>
                    <h4>Value : <?php echo $dataTransactions['Value'] ?></h4>
                    <h4>Date : <?php echo $dataTransactions['Date'] ?></h4>

                </div>

                <a id="deleteTransaction" class="link"
                   href="">Delete transaction</a><br>

                <div id="modifyTransaction">
                    <a href="">Modify
                        transaction</a>
                </div>
            </div>

        </section>

        <?php

    }

    ?>

    <div id="addButton">
        <a id="addAccount" href="../AccountViews/AddAccount.php">Add a Transaction</a>
    </div>

    <?php

} else {

    header("Location: ../Login_SignUp/Login.php");

}


?>


