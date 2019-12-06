<?php
    require "header.php";
?>

    <main>
        <div class="wrapper-main">
        <?php
            if(isset($_SESSION['userId'])){
                //Whatever we want to happen when users are logged in
                echo'<p class="login-status">You are logged IN!</p>';
            }
            else{
                //Whatever we want to happen when users are logged out
                echo'<p class="login-status">You are logged OUT!</p>';
            }
        ?>
        </div>
    </main>

<?php
    require "footer.php";
?>