<?php
require 'includes/dbh.inc.php';

if ($conn->connect_error) {
    exit('Error connecting to the database');
}

$sql = "SELECT COUNT(*) FROM imagedetails";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
} else {
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $images = mysqli_stmt_get_result($stmt);
    $imageAmount = mysqli_fetch_assoc($images);
}
mysqli_stmt_close($stmt);

$image1 = rand(1, $imageAmount['COUNT(*)']);
$image2 = rand(1, $imageAmount['COUNT(*)']);
$image3 = rand(1, $imageAmount['COUNT(*)']);

$image1Find = "SELECT Path from imagedetails WHERE $image1 = ImageID";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $image1Find);
mysqli_stmt_execute($stmt);
$img1 = mysqli_stmt_get_result($stmt);
$image1Path = mysqli_fetch_assoc($img1);
mysqli_stmt_close($stmt);

$image2Find = "SELECT Path from imagedetails WHERE $image2 = ImageID";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $image2Find);
mysqli_stmt_execute($stmt);
$img2 = mysqli_stmt_get_result($stmt);
$image2Path = mysqli_fetch_assoc($img2);
mysqli_stmt_close($stmt);

$image3Find = "SELECT Path from imagedetails WHERE $image3 = ImageID";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $image3Find);
mysqli_stmt_execute($stmt);
$img3 = mysqli_stmt_get_result($stmt);
$image3Path = mysqli_fetch_assoc($img3);
mysqli_stmt_close($stmt);
?>

<div>
    <p>Recommended</p>
</div>

<div class="rec">
    <img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/<?= $image1Path['Path'] ?>">
    <img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/<?= $image2Path['Path'] ?>">
    <img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/<?= $image3Path['Path'] ?>">
</div>