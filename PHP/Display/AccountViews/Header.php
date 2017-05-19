<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 04-05-17
 * Time: 10:24
 */

require_once("../../Class/User.php");
require_once("../../Class/Account.php");
require_once("../../Class/Transaction.php");
require_once("../../Class/DBConnect.php");
require_once("../../Class/OperationUser.php");
require_once("../../Class/OperationAccount.php");
require_once("../../Class/OperationTransaction.php");

session_start();

//Connexion à la BDD
$dbConnect = new DBConnect();
$dbConnect = $dbConnect->getDBConnection();

$operationUser = new OperationUser($dbConnect);
$operationAccount = new OperationAccount($dbConnect);
$operationTransaction = new OperationTransaction($dbConnect);

if(isset($_GET['idAccount'])) {

   $_SESSION['idAccount'] = $_GET['idAccount'];
}

//Tant que je ne revoie pas d'id de transaction, je ne fais rien avec les transactions
if(isset($_GET['idTransaction'])) {

    //Je récupère l'id de ma transaction
    $_SESSION['idTransaction'] = $_GET['idTransaction'];

    //je récupère les infos de ma transaction
    $dataTransaction = $operationTransaction->getTransactionInfo($_SESSION['idTransaction']);

    //Création d'un objet transaction
    $transaction = new Transaction($_SESSION['idAccount'], $dataTransaction['Title'], $dataTransaction['Category'], $dataTransaction['Value'], $dataTransaction['Date']);

    //Variables de sessions
    $_SESSION['Title'] = $transaction->getTitle();
    $_SESSION['Category'] = $transaction->getCategory();
    $_SESSION['Value'] = $transaction->getValue();
    $_SESSION['Date'] = $transaction->getDate();

}


//Récupération des infos de l'utilisateur grâce à son EMail
$dataUser = $operationUser->getUserInfo($_SESSION['Email']);

//Pareil pour le compte et les transactions
$dataAccount = $operationAccount->getAccountInfo($_SESSION['idAccount']);


//Construction d'un objet utilisateur
$user = new User($dataUser['Email'], $dataUser['Name'], $dataUser['FirstName'], $dataUser['Pwd'], $dataUser['UserRight']);

//Variables de sessions
$_SESSION["Name"] = $user->getName();
$_SESSION["FirstName"] = $user->getFirstName();
$_SESSION["Email"] = $user->getMail();
$_SESSION["Pwd"] = $user->getPwd();
$_SESSION["UserRight"] = $user->getUserRight();

//Construction d'un objet compte
$account = new Account($_SESSION['Email'], $dataAccount['AccountName'], $dataAccount['Type'], $dataAccount['Motto'], $dataAccount['Balance']);

//Variables de sessions
$_SESSION['AccountName'] = $account->getAccountName();
$_SESSION['Type'] = $account->getType();
$_SESSION['Motto'] = $account->getMotto();
$_SESSION['Balance'] = $account->getBalance();

?>



<head>
    <link rel="stylesheet" href="../../../CSS/StyleHome.css">
</head>

<body>
<div id="background">
    <img src="../../../Images/BackgroundIndex.jpg" alt="">
</div>

<header>
    <div id="userInfo">
        <h2><?php echo $user->getName(); ?></h2>
        <h3><?php echo $user->getFirstName(); ?></h3>
    </div>
    <div id="options">
        <h2><a href="../UserPages/Home.php">Home</a></h2>
        <h2><a id="logout" href="../Logout.php">Logout</a></h2>
        <h2><a href="../UserPages/UserModification.php">Account modification</a></h2>
    </div>
    <div id="title">
        <h1><?php echo $account->getAccountName() ?></h1>
    </div>

</header>

</body>