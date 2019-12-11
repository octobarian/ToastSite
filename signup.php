<?php
    require "header-2.php";
?>

    <main>
        <div class="wrapper-main">
            <section class="section-default">
                <h1>Signup</h1>
                <form class="form-signup" action="includes/signup.inc.php" method="post">
                <input type="text" name="fname" placeholder="First Name">
                <input type="text" name="lname" placeholder="Last Name">
                <input type="text" name="ucity" placeholder="City">
                <input type="text" name="ucountry" placeholder="Country">
                <input type="text" name="mail" placeholder="email">
                <?php 
                if(isset($_GET['error'])){
                    if($_GET['error']=="invalidmail"){
                        echo("<p>invalid email<p>");
                     }
                } 
                ?>
                <input type="password" name="pwd" placeholder="password">
                <input type="password" name="pwd-repeat" placeholder="repeat password">
                <button type="submit" name="signup-submit">Signup</button>
            </section>
        </div>
    </main>

<?php
    require "footer.php";
?>