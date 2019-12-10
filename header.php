<?php
    session_start();
?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="This is a description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title></title>
</head>

<body>
    <header>
        <nav class="nav-header-main">
            <a class="header-logo" href="index.php">
                <img src="img/toast.svg" alt="logo" height="70px" />
            </a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="photo-browser.php">Browse/Search</a></li>
                <li><a href="single-country.php">Countries</a></li>
                <li><a href="cities.php">Cities</a></li>
                <li><a href="favorites.php">Favourites</a></li>
            </ul>
            <div class="header-login">
            <?php
                if(isset($_SESSION['userId'])){
                    //Whatever we want to happen when users are logged in
                    echo'<form action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logout-submit">Logout</button>
                        </form>';
                }
                else{
                    //Whatever we want to happen when users are logged out
                    echo'<form action="includes/login.inc.php" method="post">
                    <input type="text" name="mailuid" placeholder="E-mail...">
                    <input type="password" name="pwd" placeholder="Password">
                    <button type="submit" name="login-submit">Login</button>
                    </form>
                    <a class="btn" href="signup.php">Signup</a>';
                    
                }
            ?>
            </div>
        </nav>
    </header>