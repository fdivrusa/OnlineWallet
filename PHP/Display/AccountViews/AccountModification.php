<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 14-05-17
 * Time: 10:31
 */

include_once("Header.php");
require_once("../../Class/DBConnect.php");

$dbConnect = new DBConnect();
$dbConnect = $dbConnect->getDBConnection();
$operationAcountModif = new OperationAccount($dbConnect);
$accountToModify = new Account($_SESSION['Email'], $_SESSION['AccountName'], $_SESSION['Type'], $_SESSION['Motto'], $_SESSION['Balance']);


if ($_SESSION['UserRight'] >= 1) {

    if (isset($_POST['AccountName']) && isset($_POST['Type']) && isset($_POST['Motto']) && isset($_POST['Balance']) && !empty($_POST['AccountName']) && !empty($_POST['Type']) && !empty($_POST['Motto']) && !empty($_POST['Balance'])) {

        echo 'okkkkkkkkkk';
        $operationAcountModif->modifyAccount($_SESSION['idAccount'], $_POST['AccountName'], $_POST['Type'], $_POST['Motto'], $_POST['Balance']);
        $operationAcountModif->redirect("../UserPages/Home.php");
    }

    ?>


    <head>
        <link rel="stylesheet" type="text/css" href="../../../CSS/StyleAccountAdd.css">
    </head>

    <!--Le formulaire de modification-->

    <form method="POST" action="AccountModification.php">

        <div id="addAccount">
            <h3 id="formTitle">Modify Account</h3>
            <input pattern="[A-Za-z0-9 -]{2,40}" title="Only letters or numbers. Make sure that name is not too long (50 characters max)" class="field" type="text"
                   name="AccountName" placeholder="Account Name"
                   value="<?php echo $accountToModify->getAccountName(); ?>"><br>

            <select class="field" name="Type">
                <option value="">Choose here</option>
                <option value="Current Account">Current Account</option>
                <option value="Savings Account">Savings Account</option>
                <option value="Pension Plan">Pension Plan</option>
            </select>

            <select class="field" name="Motto">
                <option value="">Choose here</option>
                <option value="Euro €">Euro €</option>
                <option value="Dollar $">Dollar $</option>
                <option value="Pound £">Pound £</option>
                <option value="Yen ¥ ">Yen ¥</option>
                <option value="Yuan Ұ ">Yuan Ұ</option>
                <option value="Won ₩">Won ₩</option>
                <option value="Rouble руб">Rouble руб</option>
            </select>

            <input class="field" type="number" min="0" name="Balance" placeholder="Balance"
                   value="<?php echo $accountToModify->getBalance(); ?>"><br>

            <input id="button" type="submit" value="Modify account">

        </div>

    </form>

    <?php

} else {

    header("Location: ../Login_SignUp/Login.php");
}

?>

