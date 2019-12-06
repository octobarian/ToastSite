<?php require_once 'config.inc.php'; ?>

<?php

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($conn->connect_error){
    exit('Error connecting to the database');
}

$id = '';

$sql ="SELECT * FROM imagedetails WHERE ImageID=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerror");
    exit();
}
else{
    if($id != null){
        mysqli_stmt_prepare($stmt, $sql);
        //Finds "s"<string> and replaces it with variable $id
        mysqli_stmt_bind_param($stmt, "s", $id);
    }
    else{
        header("Location: //index.php?error=invalidImage");
    }

    mysqli_stmt_execute($stmt);
    $image = mysqli_stmt_get_result($stmt);

    echo $image["Path"];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/filter-list.css">
</head>

<header>
    <h1>COMP 3512 Assignment 2</h1>
</header>

<body>
    <div id='photo'>

<!-- Make sure to add database reference location when hosted -->

        <img src="<?=$image['Path']?>">
    </div>
    <div id="photoInfo">
        <div id="photoTitle">
            <?= $image['Title'] ?>
        </div>
        <div id="userName">
            
        </div>
        <div id="location">

        </div>
    </div>

    <div id="favorites">

    </div>

    <div class="tripleOption">
        <div id="desc">
            <?= $image['Description']?>
        </div>
        <div id="details">

        </div>
        <div id="Map">

        </div>
    </div>
</body>
</html>
