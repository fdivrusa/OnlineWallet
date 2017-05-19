<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 19-05-17
 * Time: 10:46
 */

include_once("../AccountViews/Header.php");
require_once("../../Class/OperationAccount.php");
require_once("../../Class/OperationTransaction.php");
require_once("../../Class/Transaction.php");
require_once("../../Class/DBConnect.php");

$dbConnect = new DBConnect();
$dbConnect = $dbConnect->getDBConnection();

$operationAdaptAccountBalance = new OperationAccount($dbConnect);

$operationModify = new OperationTransaction($dbConnect);
$transactionToModify = new Transaction($_SESSION['idAccount'], $_SESSION['Title'], $_SESSION['Category'], $_SESSION['Value'], $_SESSION['Date']);


if ($_SESSION['UserRight'] >= 1) {

    if (isset($_POST['Title']) && isset($_POST['Category']) && isset($_POST['Value']) && isset($_POST['Date'])
        && !empty($_POST['Title']) && !empty($_POST['Category']) && !empty($_POST['Value']) && !empty($_POST['Date'])) {

        $_SESSION['oldValue'] = $_SESSION['Value'];
        $difference = $_SESSION['oldValue'] - $_POST['Value'];

        $operationModify->modifyTransaction($_SESSION['idTransaction'], $_POST['Title'], $_POST['Category'], $_POST['Value'], $_POST['Date']);
        $operationAdaptAccountBalance->modifyAccount($_SESSION['idAccount'], $_SESSION['AccountName'], $_SESSION['Type'], $_SESSION['Motto'],
                                                        $_SESSION['Balance'] - $difference);
        $operationModify->redirect("../TransactionViews/TransactionsView.php");

    }
    ?>

    <head>
        <link rel="stylesheet" type="text/css" href="../../../CSS/StyleTransactionAdd.css">
    </head>

    <form method="POST" action="ModifyTransaction.php">

        <div id="modTransaction">

            <h3 id="formTitle">Transaction modification</h3>

            <input pattern="[A-Za-z0-9 -]{2,40}"
                   title="Only letters or numbers. Make sure that title is not too long (40 characters max)"
                   class="field"
                   name="Title" placeholder="Transaction title" value="<?php echo $transactionToModify->getTitle() ?>">

            <select class="field" name="Category">
                <option value="">Choose here</option>
                <option value="FoodAndDrink">Food and Drink</option>
                <option value="Home">Home</option>
                <option value="Car">Car</option>
                <option value="Multimedia">Multimedia</option>
                <option value="Hobbies">Hobbies</option>
                <option value="Car">Car</option>
                <option value="Income">Income</option>
                <option value="Culture">Culture</option>
            </select>

            <input class="field" type="number" max="1000000" step="0.01" name="Value" placeholder="Value"
                   value="<?php echo $transactionToModify->getValue() ?>"><br>

            <input type="date" name="Date" value="<?php echo $transactionToModify->getDate() ?>">

            <input id="button" type="submit" value="Modify Transaction" title="Modify Transaction">

        </div>

    </form>


    <?php


} else {

    header("Location: ../Login_SignUp/Login.php");

}

?>