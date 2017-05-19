<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 16-05-17
 * Time: 17:43
 */

include_once("../AccountViews/Header.php");
require_once ("../../Class/OperationTransaction.php");
require_once ("../../Class/OperationAccount.php");
require_once ("../../Class/DBConnect.php");


$dbConnect = new DBConnect();
$dbConnect = $dbConnect->getDBConnection();

$operationTransaction = new OperationTransaction($dbConnect);

//Je dois mettre à jours mes informations dans ma BDD pour le solde du compte
$operationModifAccountBalance = new OperationAccount($dbConnect);

if ($_SESSION['UserRight']) {

    if (isset($_POST['Title']) && isset($_POST['Category']) && isset($_POST['Value']) && isset($_POST['Date']) &&
        !empty($_POST['Title']) && !empty($_POST['Category']) && !empty($_POST['Value']) && !empty($_POST['Date'])) {


        $operationModifAccountBalance->modifyAccount($_SESSION['idAccount'], $_SESSION['AccountName'], $_SESSION['Type'], $_SESSION['Motto'], $_SESSION['Balance'] + $_POST['Value']);
        $operationTransaction->addTransaction($_SESSION['idAccount'], $_POST['Title'], $_POST['Category'], $_POST['Value'], $_POST['Date']);


    } else {

        ?>
        <head>
            <link rel="stylesheet" type="text/css" href="../../../CSS/StyleTransactionAdd.css">
        </head>

        <form method="POST" action="AddTransactions.php">

            <div id="addTransaction">

                <h3 id="formTitle">Add Transaction</h3>

                <input pattern="[A-Za-z0-9 -]{2,40}"
                       title="Only letters or numbers. Make sure that title is not too long (40 characters max)"
                       class="field"
                       name="Title" placeholder="Transaction title">

                <select class="field" name="Category">
                    <option value="FoodAndDrink">Food and Drink</option>
                    <option value="Home">Home</option>
                    <option value="Car">Car</option>
                    <option value="Multimedia">Multimedia</option>
                    <option value="Hobbies">Hobbies</option>
                    <option value="Car">Car</option>
                    <option value="Income">Income</option>
                    <option value="Culture">Culture</option>
                </select>

                <input class="field" type="number" max="1000000" step="0.01" name="Value" placeholder="Value"><br>

                <input type="date" name="Date">

                <input id="button" type="submit" value="Add Transaction" title="Add Transaction">

            </div>

        </form>

        <?php
    }
} else {

    header("Location: ../Login_SignUp");
}


