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
    mysqli_stmt_bind_param($stmt, "s", $conti);
    mysqli_stmt_execute($stmt);
    $continents = mysqli_stmt_get_result($stmt);
}

?>

<div class='country-container'>
    <ul id='country-filter'>
        <h1>PLACEHOLDER FOR FILTERS</h1>
        <div id="continent-filter">
            <?php
            while ($continentsRow = mysqli_fetch_assoc($continents)) {
                echo "<li>" . $continentsRow['ContinentName'] . "</li>";
            }
            ?>
        </div>
        <!-- Add the filter options for countries here -->
    </ul>
    <ul id='country-list'>
        <!-- All of the countries will be populated here as list items -->

        <!-- Get's the list of cities -->
        <form method="GET" action="http://localhost/Github/COMP-3512-A2/single-country.php?"></form>
    </ul>
</div>
