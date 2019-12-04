<?php

require_once('config.inc.php');

/* THE 2 LINES BELOW WILL AUTOMATICALLY PRINT THE API's ONTO THE PAGE */
/* require_once('api-cities.php'); */
/* require_once('api-countries.php'); */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="filter-list.css">
</head>

<header>
    <h1>COMP 3512 Assignment 2</h1>
</header>

<body>
    <ul id='countryList'>
        <!-- All of the countries will be populated here as list items -->
    </ul>
</body>

<script src="js/api-script.js"></script>

</html>
