<?php require_once 'config.inc.php'; ?>
<?php 

 $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($conn->connect_error){
  //check if there is connection error
    exit('Error connecting to database!');
}

$iso = '';
 $sql = "SELECT * FROM countries WHERE iso=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
     //statment not allowed to prevent injection attacks
     header("Location: ../index.php?error=sqlerror");
     exit();
 }
 else{
   //if iso has been set
    if ($iso != null){
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $iso);
    }else{
        $sql = "SELECT * FROM countries";
       mysqli_stmt_prepare($stmt, $sql);
     
    }
    
    mysqli_stmt_execute($stmt);
     $result= mysqli_stmt_get_result($stmt);
     while ($row = $result->fetch_assoc()){
        $json[]=$row;
    }
   
 }
 echo json_encode($json);
 mysqli_close($conn);
?>

