<?php 

require_once 'config.inc.php';

//--------IMAGE FETCH-----------------------------------------------------------

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($conn->connect_error){
    exit('Error connecting to the database');
}

$id ='';

if(isset($_GET['ImageID'])){
    $id = $_GET['ImageID'];
}

$sql ="SELECT * FROM imagedetails WHERE ImageID=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerror");
    exit();
}
else{
    if($id != null){
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
    }
    else{
        header("Location: //index.php?error=invalidImage");
    }

    mysqli_stmt_execute($stmt);
    $image = mysqli_stmt_get_result($stmt);
    $imageRow=mysqli_fetch_assoc($image);
}
mysqli_stmt_close($stmt);

//--------USER FETCH-----------------------------------------------------------

$userFind = "SELECT * FROM users WHERE UserID=?";

$stmt = mysqli_stmt_init($conn);


if(!mysqli_stmt_prepare($stmt, $userFind)){
    header("Location: ../index.php?error=sqlerror");
    exit();
}
else{
    if($id != null){
        mysqli_stmt_prepare($stmt, $userFind);
        mysqli_stmt_bind_param($stmt, "s", $imageRow['UserID']);
    }
    else{
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

if(!mysqli_stmt_prepare($stmt, $userFind)){
    header("Location: ../index.php?error=sqlerror");
    exit();
}
else{
    if($id != null){
        mysqli_stmt_prepare($stmt, $countryFind);
        mysqli_stmt_bind_param($stmt, "s", $imageRow['CountryCodeISO']);
    }
    else{
        header("Location: //index.php?error=invalidCountry");
    }

    mysqli_stmt_execute($stmt);
    $country = mysqli_stmt_get_result($stmt);
    $countryRow = mysqli_fetch_assoc($country);
}
mysqli_stmt_close($stmt);

//-------CITY FETCH-----------------------------------------------------------

$cityFind = "SELECT * FROM cities WHERE CityCode=?";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $cityFind)){
    header("Location: ../index.php?error=sqlerror");
    exit();
}
else{
    if($id != null){
        mysqli_stmt_prepare($stmt, $cityFind);
        mysqli_stmt_bind_param($stmt, "s", $imageRow['CityCode']);
    }
    else{
        header("Location: //index.php?error=invalidCity");
    }

    mysqli_stmt_execute($stmt);
    $city = mysqli_stmt_get_result($stmt);
    $cityRow = mysqli_fetch_assoc($city);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);


require "header.php";
?>

<main>
    <div id='photo'>
        <img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/large1024/<?=$imageRow['Path']?>">
    </div>
    <div id="photoInfo">
        <div id="photoTitle">
            <?= $imageRow['Title'] ?>
        </div>
        <div id="userName">
            <?=$userRow['FirstName']?> <?=$userRow['LastName']?>
        </div>
        <div id="location">
            <?=$countryRow['CountryName']?>, <?=$cityRow['AsciiName']?>
        </div>
    </div>

    <div id="favorites">

    </div>

    <div class="tripleOption">
        <div id="desc">
            <?= $imageRow['Description']?>
        </div>
        <div id="details">

        </div>
        <div id="Map">

        </div>
    </div>
</main>

<?php require "footer.php" ?>