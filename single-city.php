<?php
require 'includes/dbh.inc.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/filter-list.css">
</head>

<header>
    <h1>COMP 3512 Assignment 2 - City Page</h1>
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
            <h1><?php ?></h1>
            <div id='city-details'>
                <!-- All of the data for the selected country -->
                <?php ?>
            </div>
        </div>

        <div class='city-map-container'>
            <h1>City Map</h1>
            <div id='city-map'>
                <!-- Map of the selected city -->
            </div>
        </div>

    </div>

</body>

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
