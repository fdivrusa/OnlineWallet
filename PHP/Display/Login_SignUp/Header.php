
<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 03-04-17
 * Time: 10:12
 */

    session_start();

    if(!isset($_SESSION['UserRight']))
    {
        $_SESSION['UserRight']=0;
    }

?>

<head>
    <link rel="stylesheet" type="text/css" href="../../../CSS/StyleHeader.css">
</head>

<body>
    <div id="Logo">
        <img class="titre" src="../../../Images/Logo.png" alt="Logo du site" title="Logo du site">
        <div id="titre">
            <h2>Online</h2>
            <h1>Wallet</h1>
        </div>
    </div>
</body>

