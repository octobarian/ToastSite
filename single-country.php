<?php
require 'includes/dbh.inc.php';
require 'includes/single-country.inc.php';

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
    <div class='main-container'>

        <div class='country-container'>
            <ul id='country-filter'>
                <h1>PLACEHOLDER FOR FILTERS</h1>
                <!-- Add the filter options for countries here -->
            </ul>
            <ul id='country-list'>
                <!-- All of the countries will be populated here as list items -->

                <!-- Get's the list of cities -->
                <form method="GET" action="http://localhost/Github/COMP-3512-A2/single-country.php?"></form>
            </ul>
        </div>

        <div class='details-container'>
            <h1><?php echo $countryRow['CountryName']; ?></h1>
            <div id='country-details'>
                <!-- All of the data for the selected country -->
                <?php populateCountryDetails($countryRow); ?>
            </div>
            <div id='country-city-list'>
                <!-- List of cities within the selected country-->
                <ul id='cities-list'>
                    <?php
                    if ($cityRow != null) {
                        while ($cityRow = mysqli_fetch_assoc($city)) {
                            echo "<li><a href=single-city.php?ISO=" . $cityRow['CountryCodeISO']  .  "&AsciiName=" . $cityRow['AsciiName'] . ">" . $cityRow['AsciiName'] . "</a></li>";
                        }
                    } else {
                        echo $countryRow['CountryName'] . " Has No Cities To Display";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class='country-photo-container'>
            <h1>Country Photos</h1>
            <div id='country-photos'>
                <!-- All of the images for the selected country -->
                <?php
                if ($photoRow != null) {
                    while ($photoRow = mysqli_fetch_assoc($photo)) {
                        //echo "<li>" . $photoRow['ImageID'] . ", " . $photoRow['Title'] . "</li>";
                        echo "<a href='single-photo.php?ImageID=" . $photoRow['ImageID'] . "'>" . "<img src=https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/" . $photoRow['Path'] . "></img></a>";
                    }
                } else {
                    echo $countryRow['CountryName'] . " Has No Photos To Display";
                }
                ?>
            </div>
        </div>

    </div>

</body>

<script src="js/api-script.js"></script>

</html>

<!-- Commented Out Format Of Country Details Section 
    <section class='details-list-section'>
        <label>Area:</label>
        <span id='country-area'></span>
        <label>Population:</label>
        <span id='country-pop'></span>
        <label>Capital City:</label>
        <span id='country-cap'></span>
        <label>Currency Name:</label>
        <span id='country-curr-name'></span>
        <label>Currency Name:</label>
        <span id='country-curr-code'></span>
        <label>Domain:</label>
        <span id='country-dom'></span>
        <label>Languages:</label>
        <span id='country-lang'></span>
        <label>Neighbours:</label>
        <span id='country-neig'></span>
        <label>Description:</label>
        <span id='country-desc'></span>
    </section> -->
