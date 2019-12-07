<?php

if(isset($_POST['login-submit'])){
    //IF YOU NEED DATABASE $conn, REQUIRE THIS DATABASEHELPER
    require 'dbh.inc.php';
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];
    //error handling empty fields
    if(empty($mailuid)||empty($password)){
        header("Location: ../index.php?error=emptyfields");
        exit();
    }
    else{
        //login with a username OR an EMAIL
        $sql = "SELECT * FROM userslogin WHERE UserName=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            //statment not allowed to prevent injection attacks
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $mailuid);
            mysqli_stmt_execute($stmt);
            //$RESULT = THE STORED PASS
            $result=mysqli_stmt_get_result($stmt);
            //is there actual data?
            if($row=mysqli_fetch_assoc($result)){
                //$digest = password_hash($password, PASSWORD_BCRYPT, ['cost'  => 12]);
                if(password_verify($password, $row['Password']) && $mailuid == $row['UserName'])
                //$digest == $row['Password'])
                //if($mailuid == $row['UserName'] && $digest == $row['Password'])
                {
                    $pwdcheck=true;
                }
                else{
                    $pwdcheck=false;
                    header("Location: ../index.php?error=wrongpwd1&p=".$row['Password']."&d=".$digest);
                    exit();
                }
                
                //$passwordHased = password_hash($password, sha_256)
                //$pwdcheck = password_verify($password,$row['Password_sha256']);
                
                if($pwdcheck == false){
                    //not the right user
                    header("Location: ../index.php?error=wrongpwd1");
                    exit();
                }
                else if($pwdcheck==true){
                    //password is correct (i use an IF statement so it doesnt default login)
                    session_start();
                    $_SESSION['userId']=$row['UserID'];
                    $_SESSION['userUid']=$row['UserName'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
                else{
                    //incase of any mistake, just error out
                    header("Location: ../index.php?error=wrongpwd2");
                    exit();
                }
            }
            else{
            header("Location: ../index.php?error=nouser");
            exit();
            }
        }
    }

}
else{
        header("Location: ../index.php");
        exit();
}

//Digest = $2y$12$iyiYzigJXCqf9yy2w3fCteAkoxCdEZ3l9GYWPD4rRPfAonpOJUcjC

