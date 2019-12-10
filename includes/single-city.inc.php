<?php
//----- City Details Fetch -----------------------------------------------------------------------------
if (isset($_GET['AsciiName'])) {
    $selectedCity = $_GET['AsciiName'];

    $sql = "SELECT * FROM cities WHERE AsciiName=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=Ascii-Name-Error");
        exit();
    } else {
        if ($selectedCity != null) {
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "s", $selectedCity);
        } else {
            header("Location: //index.php?error=passed-city-error");
        }

        mysqli_stmt_execute($stmt);
        $city = mysqli_stmt_get_result($stmt);
        $cityRow = mysqli_fetch_assoc($city);
    }
}
mysqli_stmt_close($stmt);

//----- Country Details Fetch --------------------------------------------------------------------------
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
mysqli_stmt_close($stmt);

//----- City Photos Fetch ------------------------------------------------------------------------------
$photoList = "SELECT * FROM imagedetails WHERE CityCode=?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $photoList)) {
    header("Location: ../index.php?error=sqlCityPhotoError");
    exit();
} else {
    if ($selectedCity != null) {
        mysqli_stmt_prepare($stmt, $photoList);
        mysqli_stmt_bind_param($stmt, "i", $cityRow['CityCode']);
    } else {
        header("Location: //index.php?error=city-error-B");
    }

    mysqli_stmt_execute($stmt);
    $photo = mysqli_stmt_get_result($stmt);
    $photoRow = mysqli_fetch_assoc($photo);
}

//Close the connection
mysqli_close($conn);
