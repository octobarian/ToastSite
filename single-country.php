<?php

require_once('config.inc.php');

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
            </ul>
        </div>

        <div class='details-container'>
            <div id='country-details'>
                <!-- All of the data for the selected country -->
            </div>
            <div id='country-city-list'>
                <!-- List of cities within the selected country-->
            </div>
        </div>

        <div class='country-photo-container'>
            <div id='country-photos'>
                <!-- All of the images for the selected country -->
            </div>
        </div>

    </div>

</body>

<script src="js/api-script.js"></script>

</html>
