<?php require_once 'config.inc.php'; ?>
    <?php
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    if (isset($_GET['cityCode'])) {
      $cityCode = $_GET['cityCode'];
      $sql = "select * from cities where CityCode = $cityCode";
    } else {
      $sql = "select * from cities";
    }

    $json = array();

    if ($result = mysqli_query($connection, $sql)) {
      while ($row = mysqli_fetch_assoc($result)) {
        $json[] = $row;
      }
    }

    // close the database connection
    mysqli_close($connection);
    echo json_encode($json);
    ?>
