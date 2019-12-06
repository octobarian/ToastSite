<?php
if(isset($_POST['signup-submit'])){
    //create database connection, $conn is the database if it works
    require 'dbh.inc.php';
    //grab the user info from the signup form
    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    //check for empty fields
    if(empty($username)||empty($email)||empty($password)||empty($passwordRepeat)){
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    } //check if both email and username is invalid
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)&&!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ../signup.php?error=invalidmailuid");
        exit();
    } //check if email is proper
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmail&uid=".$username);
        exit();
    } //check for allowed username (no emojis and stuff)
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ../signup.php?error=invalidusername&mail=".$email);
        exit();
    } //chack to make sure both passwords match
    elseif($password !== $passwordRepeat){
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    }
    else{
        //check if the username already exists in the database
        //we need to filter and secure input so we cant be hacked
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        //use SQL statement(stmt) check where $conn is our connection
        //prevent SQL injection: Reference: https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection
        $stmt = mysqli_stmt_init($conn);
        //check to ensure SQL connection worked again
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else{
            //s=string, i=interger, b=blob, d=double
            mysqli_stmt_bind_param($stmt,"s", $username);
            //execute the data into the database
            mysqli_stmt_execute($stmt);
            //did we get a match? then user already exists
            mysqli_stmt_store_result($stmt);
            //how many results did we get back? how many Rows were returned?
            //result is either 0 or 1
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck>0){
                header("Location: ../signup.php?error=usertaken&mail=".$email);
                exit();
            }
            else{
                //username is not taken, create the new user
                //check password, email, and userID for malicious injections
                $sql = "INSERT INTO users (uidUsers,emailUsers,pwdUsers) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                else{
                    //first, dealing with password, i need to HASH the password first
                    $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
                     mysqli_stmt_bind_param($stmt,"sss", $username, $email, $hashedPwd );
                    //execute the data into the database
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysql_close($conn);
}
else{
    header("Location: ../signup.php");
    exit();
}