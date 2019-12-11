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
