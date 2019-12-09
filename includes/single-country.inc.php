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
        header("Location: //index.php?error=cityError");
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
        header("Location: //index.php?error=cityError");
    }

    mysqli_stmt_execute($stmt);
    $photo = mysqli_stmt_get_result($stmt);
    $photoRow = mysqli_fetch_assoc($photo);
}

function populateCountryDetails($c)
{
    echo "<section class='details-list-section'>";
    echo "<label>Area:</label>";
    echo "<span id='country-area'>" . $c['Area'] . "</span>";
    echo "<label>Population:</label>";
    echo "<span id='country-pop'>" . $c['Population'] . "</span>";
    echo "<label>Capital City:</label>";
    echo "<span id='country-cap'>" . $c['Capital'] . "</span>";
    echo "<label>Currency Name:</label>";
    echo "<span id='country-curr-name'>" . $c['CurrencyName'] . "</span>";
    echo "<label>Currency Code:</label>";
    echo "<span id='country-curr-code'>" . $c['CurrencyCode'] . "</span>";
    echo "<label>Domain:</label>";
    echo "<span id='country-dom'>" . $c['TopLevelDomain'] . "</span>";
    echo "<label>Languages:</label>";
    echo "<span id='country-lang'>" . $c['Languages'] . "</span>";
    echo "<label>Neighbours:</label?";
    echo "<span id='country-neig'>" . $c['Neighbours'] . "</span>";
    echo "<label>Description:</label>";
    echo "<span id='country-desc'>" . $c['CountryDescription'] . "</span>";
    echo "</section>";
}
