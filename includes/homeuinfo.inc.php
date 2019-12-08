<div>
<p>User Info</p>
<div><p>First Name:<?php writeFirstName(); ?></p></div>
<div><p>Last Name:<?php writeLastName(); ?></p></div>
<div><p>Country:<?php writeCountry(); ?></p></div>
</div>

<?php
function writeFirstName(){
    $fname=getSQLITEM("FirstName");
    echo"$fname";
}
function writeLastName(){
    $lname=getSQLITEM("LastName");
    echo"$lname";
}
function writeCountry(){
    $cname=getSQLITEM("Country");
    echo"$cname";
}
function getSQLITEM($tofind){
    if($tofind=="FirstName"||$tofind=="LastName"||$tofind=="Country"){
        include "dbh.inc.php";
        $uid = $_SESSION['userId'];
        $sql = "SELECT * FROM users WHERE UserID = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            //statment not allowed to prevent injection attacks
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            //execute the good command
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            //$RESULT = THE STORED PASS
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
            //is there actual data?
            if($tofind=="FirstName"){return $row["FirstName"];}
            elseif($tofind=="LastName"){return $row["LastName"];}
            elseif($tofind=="Country"){return $row["Country"];}
            }
        }
    }
}
?>