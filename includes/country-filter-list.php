<?php
require 'includes/dbh.inc.php';

//-----CONTINENT FETCH ---------------------------------------------------------------------------------
$conti = "SELECT * FROM continents";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $conti)) {
    header("Location: ../index.php?error=continents-sql-error");
    exit();
} else {
    mysqli_stmt_prepare($stmt, $conti);
    mysqli_stmt_execute($stmt);
    $continents = mysqli_stmt_get_result($stmt);
}
mysqli_stmt_close($stmt);

$image = "SELECT CountryCodeISO FROM imagedetails GROUP BY CountryCodeISO";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $image);
mysqli_stmt_execute($stmt);
$img = mysqli_stmt_get_result($stmt);

$countryImageArr = [];

while($images = mysqli_fetch_assoc($img)){
    array_push($countryImageArr, $images['CountryCodeISO']);
}
$parsed = json_encode($countryImageArr);
mysqli_stmt_close($stmt);

?>



<div class='country-container'>
    <h1>Country Filters</h1>
    <div id='continent-filter'>
        <select id='continent-list'>
            <option value="invalid">Select a Continent</option>
            <?php
            while ($continentsRow = mysqli_fetch_assoc($continents)) {
                echo "<option value='" . $continentsRow['ContinentCode'] .  "'>" . $continentsRow['ContinentName'] . "</option>";
            }
            ?>
        </select>
        <button class="btn" id='continentButton' type='button' onclick='selectContinent()'>Submit</button>
        <button class="btn" id='reset' type='button' onclick='reset()'>Reset</button>
    </div>
    <button class="btn" id='hide' type='button' onclick='hideFilters()'>Hide Filters</button>
    <button class="btn" id='show' type='button' onclick='showFilters()'>Show Filters</button>
    <button class="btn" id='images' type='button' onclick='showImages(<?= $parsed ?>)'>Countries With Images</button>
    <ul>
        <!-- Add the filter options for countries here -->
    </ul>
    <h1>Countries List</h1>
    <ul id='country-list'>
        <!-- All of the countries will be populated here as list items -->
        <!-- Get's the list of cities -->
        <form method="GET" action="single-country.php"></form>
    </ul>
</div>
