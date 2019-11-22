<?php require_once 'config.inc.php'; ?>
    <?php
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

        if (mysqli_connect_errno()) {
            die(mysqli_connect_error());
        }

        if(isset($_GET['iso'])){
          $iso = $_GET['iso'];
          $sql = "select * from Countries where ISO = $iso";
        }
        else{
          $sql = "select * from Countries";
        }

        $json = array();

        if ($result = mysqli_query($connection, $sql)) {
            // loop through the data
            // while ($row = mysqli_fetch_assoc($result)) {
            //   //https://stackoverflow.com/questions/15281707/send-json-data-from-php
            //       'iso' => $row['iso'],
            //       'isonumeric' => $row['isonumeric'],
            //       'countryname' => $row['countryname'],
            //       'captial' => $row['citycode'],
            //       'area' => $row['area'],
            //       'population' => $row['population'],
            //       `Continent` => $row['continent'];
            //       `TopLevelDomain` => $row['topleveldomain'];
            //       `CurrencyCode` => $row['currencycode'];
            //       `CurrencyName` => $row['currencyname'];
            //       `PhoneCountryCode` => $row['phonecountrycode'];
            //       `Languages` => $row['languages'];
            //       `Neighbours` => $row['neighbours'];
            //       `CountryDescription` => $row['countrydescription'];
            //     )
            //https://stackoverflow.com/questions/383631/json-encode-mysql-results
              while($r = mysqli_fetch_assoc($result)) {
                $json[] = $r;
              }

            // release the memory used by the result set
            mysqli_free_result($result);
        }
        // close the database connection
        mysqli_close($connection);
        echo json_encode($json);
        ?>
