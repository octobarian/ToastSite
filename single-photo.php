<?php

require 'includes/dbh.inc.php';
//--------IMAGE FETCH-----------------------------------------------------------

if ($conn->connect_error) {
    exit('Error connecting to the database');
}

$id = '';

if (isset($_GET['ImageID'])) {
    $id = $_GET['ImageID'];
}

$sql = "SELECT * FROM imagedetails WHERE ImageID=?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
} else {
    if ($id != null) {
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
    } else {
        header("Location: //index.php?error=invalidImage");
    }

    mysqli_stmt_execute($stmt);
    $image = mysqli_stmt_get_result($stmt);
    $imageRow = mysqli_fetch_assoc($image);
}
mysqli_stmt_close($stmt);

//--------USER FETCH-----------------------------------------------------------

$userFind = "SELECT * FROM users WHERE UserID=?";

$stmt = mysqli_stmt_init($conn);


if (!mysqli_stmt_prepare($stmt, $userFind)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
} else {
    if ($id != null) {
        mysqli_stmt_prepare($stmt, $userFind);
        //Finds "s"<string> and replaces it with variable $id
        mysqli_stmt_bind_param($stmt, "s", $imageRow['UserID']);
    } else {
        header("Location: //index.php?error=invalidUser");
    }

    mysqli_stmt_execute($stmt);
    $user = mysqli_stmt_get_result($stmt);
    $userRow = mysqli_fetch_assoc($user);
}
mysqli_stmt_close($stmt);

//--------COUNTRY FETCH-----------------------------------------------------------

$countryFind = "SELECT * FROM countries WHERE ISO=?";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $userFind)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
} else {
    if ($id != null) {
        mysqli_stmt_prepare($stmt, $countryFind);
        //Finds "s"<string> and replaces it with variable $id
        mysqli_stmt_bind_param($stmt, "s", $imageRow['CountryCodeISO']);
    } else {
        header("Location: //index.php?error=invalidUser");
    }

    mysqli_stmt_execute($stmt);
    $country = mysqli_stmt_get_result($stmt);
    $countryRow = mysqli_fetch_assoc($country);
}
mysqli_stmt_close($stmt);

//-------CITY FETCH-----------------------------------------------------------

$cityFind = "SELECT * FROM cities WHERE CityCode=?";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $cityFind)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
} else {
    if ($id != null) {
        mysqli_stmt_prepare($stmt, $cityFind);
        //Finds "s"<string> and replaces it with variable $id
        mysqli_stmt_bind_param($stmt, "s", $imageRow['CityCode']);
    } else {
        header("Location: //index.php?error=invalidUser");
    }

    mysqli_stmt_execute($stmt);
    $city = mysqli_stmt_get_result($stmt);
    $cityRow = mysqli_fetch_assoc($city);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);


require "header.php";
?>

<link rel="stylesheet" href="css/singlephoto.css">
<script src="js/single-photo.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBx5bCyeIQLxZ6gD7WNySf9t9AEQV9SOr8"></script>

<main>
    <div id='container'>
        <div id='photo'>
            <img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/large1024/<?= $imageRow['Path'] ?>">
        </div>

        <div id='infoContainer'>
            <div id="photoInfo">
                <div id="photoTitle">
                    <h1><?= $imageRow['Title'] ?></h1>
                </div>
                <div id="userName">
                    <h4> <?= $userRow['FirstName'] ?> <?= $userRow['LastName'] ?></h4>
                </div>
                <div id="location">
                    <h4> <?= $countryRow['CountryName'] ?>, <?= $cityRow['AsciiName'] ?></h4>
                </div>
            </div>

            <div id="favorites">
                <!-- https://stackoverflow.com/questions/20738329/how-to-call-a-php-function-on-the-click-of-a-button -->
                <form action="" method="post">
                    <input type="submit" id="button" name="fav" value="Add to Favorites">
                </form>
            </div>
            <div id="bottomInfo">
                <div class="tripleButton" id="buttDesc">
                    <p>Description</p>
                </div>
                <div class="tripleButton" id="buttDet">
                    <p>Details</p>
                </div>
                <div class="tripleButton" id="buttMap">
                    <p>Map</p>
                </div>
                <div class="tripleOption">
                    <div id="desc">
                        <?= $imageRow['Description'] ?>
                    </div>
                    <div id="details">
                        <script>
                            displayDetails(<?= json_encode($imageRow) ?>)
                        </script>
                    </div>
                    <div id="Map">
                        <script>
                            createMap(<?= $cityRow['Latitude'] ?>, <?= $cityRow['Longitude'] ?>);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require "footer.php";

if (isset($_POST['fav'])) {
    if (isset($_SESSION['favPhotos'])) {
        array_push($_SESSION['favPhotos'], $imageRow['Path']);
    } else {
        $_SESSION['favPhotos'] = array($imageRow['Path']);
    }
}

?>