<?php
require 'includes/dbh.inc.php';
require 'header-2.php';

require 'includes/single-country.inc.php';
require 'includes/single-city.inc.php';
?>

<head>
    <!--<meta charset="UTF-8">
    <title>Document</title>-->
    <link rel="stylesheet" href="css/filter-list.css">
</head>

<body>
    <div class='main-container'>

        <?php require 'includes/country-filter-list.php'; ?>

        <div class='details-container'>
            <h1><span id="main-area-name"><?php echo $cityRow['AsciiName']; ?></span></h1>
            <div id='city-details'>
                <!-- All of the data for the selected country -->
                <?php
                echo "<section class='details-list-section'>";
                echo "<label>Population:</label>";
                echo "<span id='city-pop'>" . $cityRow['Population'] . "</span>";
                echo "<label>Elevation:</label>";
                echo "<span id='city-elev'>" . $cityRow['Elevation'] . "</span>";
                echo "<label>Timezone:</label>";
                echo "<span id='city-timezone'>" . $cityRow['TimeZone'] . "</span>";
                echo "</section>";
                ?>
            </div>

            <div class='city-map-container'>
                <h1>City Location Map</h1>
                <div id='city-map'>
                    <!-- Map of the selected city -->
                    <?php

                    echo "<img width='100%' src='https://maps.googleapis.com/maps/api/staticmap?center=" . $countryRow['CountryName'] . "&zoom=4&scale=1&size=600x300&maptype=roadmap&key=AIzaSyAKn1BfAJIrxQjmPh6tILvS68lozh5eHLs&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C" . $cityRow['Latitude'] . ",+" . $cityRow['Longitude'] . "'></img>";

                    ?>
                </div>
            </div>
        </div>

        <div class='country-photo-container'>
            <h1>City Photos</h1>
            <div id='city-photos'>
                <!-- All of the images for the selected city -->
                <?php
                if ($photoRow != null) {
                    while ($photoRow = mysqli_fetch_assoc($photo)) {
                        //echo "<li>" . $photoRow['ImageID'] . ", " . $photoRow['Title'] . "</li>";
                        echo "<a href='single-photo.php?ImageID=" . $photoRow['ImageID'] . "'>" . "<img src=https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/" . $photoRow['Path'] . "></img></a>";
                    }
                } else {
                    echo $cityRow['AsciiName'] . " Has No Photos To Display";
                }
                ?>
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
