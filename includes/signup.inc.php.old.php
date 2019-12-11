<?php
if(isset($_POST['signup-submit'])){
    //create database connection, $conn is the database if it works
    require 'dbh.inc.php';
    //grab the user info from the signup form
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $ucity = $_POST['ucity'];
    $ucountry = $_POST['ucountry'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    //check for empty fields
    if(empty($email)||empty($password)||empty($passwordRepeat)||empty($fname)||empty($lname)||empty($ucity)||empty($ucountry)){
        header("Location: ../signup.php?error=emptyfields&mail=".$email);
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
        $sql = "SELECT UserID FROM userslogin WHERE UserID=?";
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
            mysqli_stmt_bind_param($stmt,"s", $email);
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
                $sqluser = "INSERT INTO userslogin (UserName,Password,DateJoined) VALUES (?,?,?)";
                // `UserID` int(11) NOT NULL,
                // `FirstName` varchar(255) DEFAULT NULL,
                // `LastName` varchar(255) DEFAULT NULL,
                // `Address` varchar(255) DEFAULT NULL,
                // `City` varchar(255) DEFAULT NULL,
                // `Region` varchar(255) DEFAULT NULL,
                // `Country` varchar(255) DEFAULT NULL,
                // `Postal` varchar(255) DEFAULT NULL,
                // `Phone` varchar(255) DEFAULT NULL,
                // `Email` varchar(255) DEFAULT NULL,
                // `Privacy` varchar(255) DEFAULT NULL,
                $sqlinfo = "INSERT INTO users (UserId, FirstName, LastName, City, Country, Email) VALUES (?,?,?,?,?,?)";
                $stmt2 = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt2,$sqluser)){
                    header("Location: ../signup.php?error=sqlerroruser");
                    exit();
                }
                else{
                    //grab today's date
                    $datejoined = "1";
                    mysqli_stmt_prepare($stmt2,$sqluser);
                    //first, dealing with password, i need to HASH the password first
                    $hashedPwd = password_hash($password,PASSWORD_BCRYPT, ["cost" => 12]);
                    mysqli_stmt_bind_param($stmt2,"sss", $email, $hashedPwd, $datejoined );
                    //execute the data into the database
                    mysqli_stmt_execute($stmt2);
                    $userAdded = true;
                    // header("Location: ../signup.php?signup=success");
                    // exit();
                }

                //Second, Get the information and insert it into the USERINFO database
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sqlinfo)){
                    header("Location: ../signup.php?error=sqlerrorinfo");
                    exit();
                }
                else{
                    $sqlgetuserID = "SELECT UserID from UsersLogin WHERE UserName=?";
                    mysqli_stmt_prepare($stmt,$sqlgetuserID);
                    mysqli_stmt_bind_param($stmt,"s", $email);
                    $result = mysqli_stmt_get_result($stmt2);
                    $row=mysqli_fetch_assoc($result);
                    $userid = $row['UserID'];//SQL GET USER ID
                     mysqli_stmt_bind_param($stmt,"ssssss", $userid, $fname, $lname, $ucity, $ucountry, $email);
                    //execute the data into the database
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success&useradded=".$userAdded);
                    exit();
                    
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);
    mysql_close($conn);
}
else{
    header("Location: ../signup.php");
    exit();
}