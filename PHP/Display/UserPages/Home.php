<?php
/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 20-04-17
 * Time: 12:22
 */

include_once("Header.php");

if ($_SESSION['UserRight'] == 2) {

    $dbConnect = new DBConnect();
    $dbConnect = $dbConnect->getDBConnection();

    $req = $dbConnect->query("SELECT * FROM users");

    while ($data = $req->fetch()) {


        ?>

        <div id="users">

            <div id="display">

                <form action="Home.php" method="GET">

                    <div id="info">

                        <p>Email : <input name="Email" type="text" value="<?php echo $data['Email'] ?>"></p>
                        <p>Name : <input name="Name" type="text" value="<?php echo $data['Name'] ?>"></p>
                        <p>FirstName : <input name="FirstName" type="text" value="<?php echo $data['FirstName'] ?>"></p>
                        <p>UserRight : <input name="UserRight" type="text" value="<?php echo $data['UserRight'] ?>"></p>

                    </div>

                    <input id="buttonModif" class="button" type="submit" value="Modify user">
                    <button class="button">Delete User</button>

                </form>

            </div>

        </div>


        <?php

    }

} else if ($_SESSION['UserRight'] == 1) {


} else {

    header("Location: ../Login_SignUp/Login.php");
}


?>




