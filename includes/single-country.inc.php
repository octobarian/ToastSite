<?php

if ($conn->connect_error) {
    exit("Error connecting to the database");
}
//-----COUNTRY ISO FETCH--------------------------------------------------------------------------------

//Checks to see if the user has clicked a link
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['ISO'])) {
        $selectedCountry = $_GET['ISO'];

        $sql = "SELECT * FROM countries WHERE ISO=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=countryISOerror");
            exit();
        } else {
            if ($selectedCountry != null) {
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "s", $selectedCountry);
            } else {
                header("Location: //index.php?error=selectedCountryError");
            }

            mysqli_stmt_execute($stmt);
            $country = mysqli_stmt_get_result($stmt);
            $countryRow = mysqli_fetch_assoc($country);
        }
    }
}
mysqli_stmt_close($stmt);

//-----CITY FETCH---------------------------------------------------------------------------------------
$listCities = "SELECT * FROM cities WHERE CountryCodeISO=?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $listCities)) {
    header("Location: ../index.php?error=sqlCitiesError");
    exit();
} else {
    if ($selectedCountry != null) {
        mysqli_stmt_prepare($stmt, $listCities);
        mysqli_stmt_bind_param($stmt, "s", $selectedCountry);
    } else {
        header("Location: //index.php?error=countryError-A");
    }

    mysqli_stmt_execute($stmt);
    $city = mysqli_stmt_get_result($stmt);
    $cityRow = mysqli_fetch_assoc($city);
}

mysqli_stmt_close($stmt);

//-----COUNTRY PHOTOS-----------------------------------------------------------------------------------
$photoList = "SELECT * FROM imagedetails WHERE CountryCodeISO=?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $photoList)) {
    header("Location: ../index.php?error=sqlCitiesError");
    exit();
} else {
    if ($selectedCountry != null) {
        mysqli_stmt_prepare($stmt, $photoList);
        mysqli_stmt_bind_param($stmt, "s", $selectedCountry);
    } else {
        header("Location: //index.php?error=countryError-B");
    }

    mysqli_stmt_execute($stmt);
    $photo = mysqli_stmt_get_result($stmt);
    $photoRow = mysqli_fetch_assoc($photo);
}

mysqli_stmt_close($stmt);

//Close the connection
mysqli_close($conn);
