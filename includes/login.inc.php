<?php

if(isset($_POST['login-submit'])){
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
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            //statment not allowed to prevent injection attacks
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            //is there actual data?
            if($row=mysqli_fetch_assoc($result)){
                $pwdcheck = password_verify($password,$row['pwdUsers']);
                if($pwdcheck == false){
                    //not the right user
                    header("Location: ../index.php?error=wrongpwd");
                    exit();
                }
                else if($pwdcheck==true){
                    //password is correct (i use an IF statement so it doesnt default login)
                    session_start();
                    $_SESSION['userId']=$row['idUsers'];
                    $_SESSION['userUid']=$row['uidUsers'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
                else{
                    //incase of any mistake, just error out
                    header("Location: ../index.php?error=wrongpwd");
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