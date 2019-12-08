<?php
    require "header.php";
?>

    <main>
        <?php
            if(isset($_SESSION['userId'])){
                //Whatever we want to happen when users are logged in
                echo'<p class="login-status">You are logged IN!</p>';
                include "includes/loggedin.inc.php";
            }
            else{
                //Whatever we want to happen when users are logged out
                echo'<p class="login-status">You are logged OUT!</p>';
                include "includes/loggedout.inc.php";
            }
        ?>
    </main>

<?php
    require "footer.php";
?>